<?php

namespace App\Http\Controllers\Admin;

use App\Mail\AdminPasswordResetOtpMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class AuthController extends BaseAdminController
{
    private const OTP_EXPIRES_IN_MINUTES = 10;

    public function create(): View|RedirectResponse
    {
        if (session()->has('admin_token')) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $login = $this->apiService->login($credentials);

        if (! $login['ok']) {
            return $this->backWithApiError($login, 'Unable to sign in.');
        }

        $token = $login['data']['token'] ?? $login['raw']['token'] ?? null;

        if (! $token) {
            return back()->withErrors([
                'email' => 'Login succeeded but no API token was returned.',
            ])->withInput();
        }

        $profile = $this->apiService->profile($token);
        $roles = collect($profile['data']['roles'] ?? [])->pluck('name');

        if (! $profile['ok'] || ! $roles->contains('admin')) {
            $this->apiService->logout($token);

            return back()->withErrors([
                'email' => 'This account does not have admin access.',
            ])->withInput();
        }

        $request->session()->put('admin_token', $token);
        $request->session()->put('admin_user', $profile['data']);
        $request->session()->put('admin_profile_checked_at', time());

        return redirect()->route('admin.dashboard')->with('success', 'Welcome back.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $token = $request->session()->get('admin_token');

        if ($token) {
            $this->apiService->logout($token);
        }

        $request->session()->forget(['admin_token', 'admin_user', 'admin_profile_checked_at']);

        return redirect()->route('admin.login')->with('success', 'You have been logged out.');
    }

    public function profile(Request $request): View|RedirectResponse
    {
        $profile = $this->apiService->profile($request->session()->get('admin_token'));

        if (! $profile['ok']) {
            return redirect()->route('admin.dashboard')->with('error', $profile['message'] ?: 'Unable to load profile details.');
        }

        $request->session()->put('admin_user', $profile['data']);
        $request->session()->put('admin_profile_checked_at', time());

        return view('admin.profile.show', [
            'profile' => $profile['data'],
        ]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $payload = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $response = $this->apiService->put('auth/profile', $payload, $request->session()->get('admin_token'));

        if (! $response['ok']) {
            return $this->backWithApiError($response, 'Unable to update profile.');
        }

        $freshProfile = $this->apiService->profile($request->session()->get('admin_token'));
        $updatedProfile = $freshProfile['ok'] ? $freshProfile['data'] : ($response['data'] ?? $payload);

        $request->session()->put('admin_user', $updatedProfile);
        $request->session()->put('admin_profile_checked_at', time());

        return redirect()->route('admin.profile.show')->with('success', $response['message'] ?: 'Profile updated successfully.');
    }

    public function showForgotPasswordForm(): View|RedirectResponse
    {
        if (session()->has('admin_token')) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.forgot-password');
    }

    public function sendResetOtp(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
        ]);

        $admin = $this->findAdminByEmail($validated['email']);

        if (! $admin) {
            return back()->withErrors([
                'email' => 'Admin account with this email was not found.',
            ])->withInput();
        }

        $existingReset = DB::table('password_reset_tokens')->where('email', $admin->email)->first();

        if ($existingReset?->created_at && Carbon::parse($existingReset->created_at)->gt(now()->subMinute())) {
            return back()->withErrors([
                'email' => 'Please wait one minute before requesting another OTP.',
            ])->withInput();
        }

        $otp = (string) random_int(100000, 999999);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $admin->email],
            [
                'token' => Hash::make($otp),
                'created_at' => now(),
            ]
        );

        try {
            Mail::to($admin->email)->send(new AdminPasswordResetOtpMail($admin, $otp, self::OTP_EXPIRES_IN_MINUTES));
        } catch (\Throwable $exception) {
            report($exception);

            return back()->withErrors([
                'email' => 'OTP email could not be sent. Please check mail settings and try again.',
            ])->withInput();
        }

        $request->session()->forget('admin_password_reset_verified');
        $request->session()->put('admin_password_reset_email', $admin->email);

        return redirect()
            ->route('admin.password.otp', ['email' => $admin->email])
            ->with('success', 'OTP has been sent to the admin email address.');
    }

    public function showOtpVerificationForm(Request $request): View|RedirectResponse
    {
        if (session()->has('admin_token')) {
            return redirect()->route('admin.dashboard');
        }

        $email = $request->query('email', $request->session()->get('admin_password_reset_email'));

        if (! $email) {
            return redirect()->route('admin.password.request');
        }

        return view('admin.auth.verify-otp', [
            'email' => $email,
            'expiresInMinutes' => self::OTP_EXPIRES_IN_MINUTES,
        ]);
    }

    public function verifyResetOtp(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'otp' => ['required', 'digits:6'],
        ]);

        $admin = $this->findAdminByEmail($validated['email']);

        if (! $admin) {
            return back()->withErrors([
                'email' => 'Admin account with this email was not found.',
            ])->withInput();
        }

        $reset = DB::table('password_reset_tokens')->where('email', $admin->email)->first();

        if (! $reset) {
            return back()->withErrors([
                'otp' => 'OTP not found. Please request a new OTP.',
            ])->withInput();
        }

        $createdAt = $reset->created_at ? Carbon::parse($reset->created_at) : null;

        if (! $createdAt || $createdAt->lte(now()->subMinutes(self::OTP_EXPIRES_IN_MINUTES))) {
            DB::table('password_reset_tokens')->where('email', $admin->email)->delete();

            return back()->withErrors([
                'otp' => 'OTP has expired. Please request a new one.',
            ])->withInput();
        }

        if (! Hash::check($validated['otp'], $reset->token)) {
            return back()->withErrors([
                'otp' => 'Entered OTP is invalid.',
            ])->withInput();
        }

        $request->session()->put('admin_password_reset_verified', [
            'email' => $admin->email,
            'verified_at' => now()->timestamp,
        ]);

        return redirect()->route('admin.password.reset', ['email' => $admin->email]);
    }

    public function showResetPasswordForm(Request $request): View|RedirectResponse
    {
        if (session()->has('admin_token')) {
            return redirect()->route('admin.dashboard');
        }

        $email = $request->query('email');
        $verified = $request->session()->get('admin_password_reset_verified');

        if (! $email || ! $verified || ($verified['email'] ?? null) !== $email) {
            return redirect()->route('admin.password.request')->with('error', 'Verify OTP before resetting password.');
        }

        return view('admin.auth.reset-password', [
            'email' => $email,
        ]);
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $verified = $request->session()->get('admin_password_reset_verified');

        if (! $verified || ($verified['email'] ?? null) !== $validated['email']) {
            return redirect()->route('admin.password.request')->with('error', 'OTP verification is required before password reset.');
        }

        $admin = $this->findAdminByEmail($validated['email']);

        if (! $admin) {
            return redirect()->route('admin.password.request')->withErrors([
                'email' => 'Admin account with this email was not found.',
            ]);
        }

        $admin->update([
            'password' => $validated['password'],
        ]);

        DB::table('password_reset_tokens')->where('email', $admin->email)->delete();
        $request->session()->forget(['admin_password_reset_email', 'admin_password_reset_verified']);

        return redirect()->route('admin.login')->with('success', 'Admin password has been reset. Please login with the new password.');
    }

    private function findAdminByEmail(string $email): ?User
    {
        return User::query()
            ->where('email', $email)
            ->get()
            ->first(fn (User $user) => $user->hasRole('admin'));
    }
}
