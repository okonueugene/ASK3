<?php

namespace App\Http\Controllers\Api\Tool;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ToolAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:6',
        ]);

        $credentials = $request->only(['email', 'password']);

        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            $token = $user->createToken('authToken')->plainTextToken;
            // dd($user->user_type);
            if ($user->user_type == 'admin' || $user->user_type == 'super_admin') {
                $data['company'] = $user->company;
                $data['user'] = $user;
                $data['token'] = $token;

                return response()->json([
                    'success' => true,
                    'message' => 'Login successful',
                    //company details
                    'company_name' => $user->company->company_name,
                    'company_id' => $user->company->id,
                    'company_status' => $user->company->status,

                    //user details
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'user_email' => $user->email,
                    'user_phone' => $user->phone,
                    'user_type' => $user->user_type,
                    'user_token' => $token,
                ]);

            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Only site admins have access to this tool',
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid login details',
            ]);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout successful',
        ]);
    }
}
