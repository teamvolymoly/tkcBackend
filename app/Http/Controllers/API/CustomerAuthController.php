<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class CustomerAuthController extends Controller
{

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>false,
                'message'=>$validator->errors()
            ],422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $customerRole = Role::firstOrCreate([
            'name' => 'customer',
            'guard_name' => config('auth.defaults.guard', 'web'),
        ]);

        $user->assignRole($customerRole);

        $token = $user->createToken('customer_token')->plainTextToken;

        return response()->json([
            'status'=>true,
            'message'=>'Customer registered successfully',
            'token'=>$token,
            'user'=>$user
        ], 201);

    }

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'email'=>'required|email',
            'password'=>'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>false,
                'message'=>$validator->errors()
            ],422);
        }

        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password,$user->password)){
            return response()->json([
                'status'=>false,
                'message'=>'Invalid credentials'
            ],401);
        }

        $isCustomer = $user->hasRole('customer') || data_get($user, 'role') === 'customer';

        if (!$isCustomer) {
            return response()->json([
                'status' => false,
                'message' => 'Only customer accounts can use this login endpoint',
            ], 403);
        }

        $token = $user->createToken('customer_token')->plainTextToken;

        return response()->json([
            'status'=>true,
            'message'=>'Login successful',
            'token'=>$token,
            'user'=>$user
        ]);

    }

    public function logout(Request $request)
    {

        $request->user()->tokens()->delete();
        return response()->json([
            'status'=>true,
            'message'=>'Logged out successfully'
        ]);

    }

    public function userGet(Request $request)
    {
        $loginUser = $request->user();

        $users = User::with('roles')
            ->where('id', '!=', $loginUser->id)
            ->get()
            ->filter(function (User $user) {
                return !$user->hasRole('admin') && data_get($user, 'role') !== 'admin';
            })
            ->values();

        $allUsers = collect([$loginUser])->merge($users);

        return response()->json([
            'status' => true,
            'users' => $allUsers
        ]);
    }

}

