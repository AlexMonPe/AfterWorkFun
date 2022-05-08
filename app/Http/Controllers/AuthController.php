<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nick' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string',
                'steamUserName' => 'string|max:45',
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors()->toJson(), 400);
            }
            $user = User::create([
                'nick' => $request->get('nick'),
                'email' => $request->get('email'),
                'password' => bcrypt($request->password),
                'steamUserName' => $request->get('steamUserName'),
            ]);
            $token = JWTAuth::fromUser($user);
            Log::info('new user created called ' . $user->nick);
            return response()->json(compact('user', 'token'), 201);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json(['error' => ' error registering user ' . $th->getMessage()], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $input = $request->only('email', 'password');
            $jwt_token = null;

            if (!$jwt_token = JWTAuth::attempt($input)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid Email or Password',
                ], Response::HTTP_UNAUTHORIZED);
            }

            return response()->json([
                'success' => true,
                'token' => $jwt_token,
            ]);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json(['error' => ' Error in login ' . $th->getMessage()], 500);
        }
    }
}
