<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $request->password,
        ]);

        $role = Role::firstOrCreate([
            'name' => 'customer',
            'guard_name' => config('auth.defaults.guard', 'web'),
        ]);

        $user->assignRole($role);

        return response()->json([
            'status' => true,
            'message' => 'Registered successfully',
            'token' => $user->createToken('auth_token')->plainTextToken,
            'user' => $user,
        ], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['status' => false, 'message' => 'Invalid credentials'], 401);
        }

        return response()->json([
            'status' => true,
            'message' => 'Login successful',
            'token' => $user->createToken('auth_token')->plainTextToken,
            'user' => $user,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()?->delete();

        return response()->json(['status' => true, 'message' => 'Logged out']);
    }

    public function refresh(Request $request)
    {
        $user = $request->user();
        $request->user()->currentAccessToken()?->delete();

        return response()->json([
            'status' => true,
            'token' => $user->createToken('auth_token')->plainTextToken,
        ]);
    }

    public function profile(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'status' => true,
            'data' => $user->canAccessAdminPanel()
                ? $user->adminProfileData()
                : $user->customerProfileData(),
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'sometimes|required|email|unique:users,email,'.$user->id,
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $user->update($request->only(['name', 'email', 'phone']));

        $freshUser = $user->fresh();

        return response()->json([
            'status' => true,
            'message' => 'Profile updated',
            'data' => $freshUser->canAccessAdminPanel()
                ? $freshUser->adminProfileData()
                : $freshUser->customerProfileData(),
        ]);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['status' => false, 'message' => 'Current password is incorrect'], 422);
        }

        $user->update(['password' => $request->password]);

        return response()->json(['status' => true, 'message' => 'Password changed successfully']);
    }
}
