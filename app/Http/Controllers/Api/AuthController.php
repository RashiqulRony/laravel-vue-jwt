<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * @bodyParam email string required
     * @bodyParam password string required
     * @response {
     * "status": true,
     * "token": "JWT Auth Token",
     * "user": {
     * "id": 1,
     * "name": "Rashiqul Rony",
     * "email": "rony.mmj@gmail.com",
     * "created_at": "2021-02-24 17:27:55",
     * "updated_at": "2021-02-24 17:27:55"
     * }
     * "expires": "Token Expired time"
     * }
     */
    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            if (!$token = auth('api')->attempt($credentials)) {
                return response()->json(['status'=> false, 'error' => 'Unauthorized']);
            }

            $user = auth('api')->user();
            return response()->json([
                'status'=> true,
                'message'=> "Login successfully",
                'token' => $token,
                'token_type' => 'bearer',
                'user' => $user,
                'expires' => auth('api')->factory()->getTTL() * 60,
            ]);
        }catch (\Exception $exception) {
            return response()->json([
                'status'=> false,
                'message'=> $exception->getMessage(),
            ]);
        }
    }

    /**
     * @bodyParam name string required
     * @bodyParam email string required
     * @bodyParam password string required min:6
     * @bodyParam password_confirmation string required
     * @response {
     * "status": true,
     * "message": "Thanks for signing up! Please login now."
     * }
     */
    public function register(Request $request)
    {
        $credentials = $request->only('name', 'email', 'password', 'password_confirmation');
        $rules = [
            'name' => 'required|max:191',
            'email' => 'required|email|max:191|unique:users',
            'password' => 'required|string|min:8|max:50|confirmed'
        ];

        try {
            $validator = Validator::make($credentials, $rules);
            if($validator->fails()) {
                return response()->json(['status' => false, 'errors'=> $validator->messages()]);
            }
            User::create([
                'name'              => $request->name,
                'email'             => $request->email,
                'password'          => Hash::make($request->password),
                'email_verified_at' => now(),
            ]);
            return response()->json([
                'status'=> true,
                'message'=> 'Thanks for signing up! Please login now.'
            ]);

        } catch (\Exception $exception) {
            return response()->json([
                'status'=> false,
                'message'=> $exception->getMessage()
            ]);
        }
    }

    /**
     * @authenticated
     * @response {
     * "success": true,
     * "message": "Successfully logged out"
     * }
     */
    public function logout()
    {
        auth('api')->logout();
        return response()->json(['status'=> true, 'message' => 'Successfully logged out']);
    }
}
