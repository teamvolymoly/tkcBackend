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
        $permissions = collect($profile['data']['permissions'] ?? [])->pluck('name');

        if (! $profile['ok'] || (! $roles->contains('admin') && ! $permissions->contains('admin.access'))) {
            $this->apiService->logout($token);

            return back()->withErrors([
                'email' => 'This account does not have admin panel access.',
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

        $user = User::query()
            ->where('email', $validated['email'])
            ->get()
            ->first(fn (User $user) => $user->canAccessAdminPanel());

        if (! $user) {
            return back()->withErrors([
                'email' => 'We could not find an admin account with that email address.',
            ])->withInput();
        }

        $otp = (string) random_int(100000, 999999);
        $expiresAt = Carbon::now()->addMinutes(self::OTP_EXPIRES_IN_MINUTES);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => Hash::make($otp),
                'created_at' => Carbon::now(),
            ]
        );

        session([
            'admin_password_reset_email' => $user->email,
            'admin_password_reset_expires_at' => $expiresAt->timestamp,
        ]);

        Mail::to($user->email)->send(new AdminPasswordResetOtpMail($otp, $user->name, $expiresAt));

        return redirect()->route('admin.password.otp')->with('success', 'A verification code has been sent to your email address.');
    }

    public function showOtpVerificationForm(): View|RedirectResponse
    {
        $email = session('admin_password_reset_email');

        if (! $email) {
            return redirect()->route('admin.password.request')->with('error', 'Start the password reset flow first.');
        }

        return view('admin.auth.verify-otp', [
            'email' => $email,
            'expiresAt' => session('admin_password_reset_expires_at'),
        ]);
    }

    public function verifyResetOtp(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $email = session('admin_password_reset_email');
        $expiresAt = session('admin_password_reset_expires_at');

        if (! $email || ! $expiresAt) {
            return redirect()->route('admin.password.request')->with('error', 'Start the password reset flow first.');
        }

        if (Carbon::now()->timestamp > (int) $expiresAt) {
            session()->forget(['admin_password_reset_email', 'admin_password_reset_expires_at', 'admin_password_reset_verified']);
            DB::table('password_reset_tokens')->where('email', $email)->delete();

            return redirect()->route('admin.password.request')->withErrors([
                'email' => 'Your verification code has expired. Please request a new one.',
            ]);
        }

        $record = DB::table('password_reset_tokens')->where('email', $email)->first();

        if (! $record || ! Hash::check($validated['otp'], $record->token)) {
            return back()->withErrors([
                'otp' => 'The verification code is incorrect.',
            ])->withInput();
        }

        session(['admin_password_reset_verified' => true]);

        return redirect()->route('admin.password.reset')->with('success', 'Verification successful. Set your new password.');
    }

    public function showResetPasswordForm(): View|RedirectResponse
    {
        if (! session('admin_password_reset_verified')) {
            return redirect()->route('admin.password.request')->with('error', 'Verify your email before resetting your password.');
        }

        return view('admin.auth.reset-password', [
            'email' => session('admin_password_reset_email'),
        ]);
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $email = session('admin_password_reset_email');

        if (! $email || ! session('admin_password_reset_verified')) {
            return redirect()->route('admin.password.request')->with('error', 'Restart the password reset process.');
        }

        $user = User::query()
            ->where('email', $email)
            ->get()
            ->first(fn (User $user) => $user->canAccessAdminPanel());

        if (! $user) {
            return redirect()->route('admin.password.request')->withErrors([
                'email' => 'We could not find an admin account for this reset request.',
            ]);
        }

        $user->forceFill([
            'password' => Hash::make($validated['password']),
        ])->save();

        DB::table('password_reset_tokens')->where('email', $email)->delete();
        session()->forget(['admin_password_reset_email', 'admin_password_reset_expires_at', 'admin_password_reset_verified']);

        return redirect()->route('admin.login')->with('success', 'Your password has been updated. You can sign in now.');
    }
}
