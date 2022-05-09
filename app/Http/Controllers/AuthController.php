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
    const ROLE_USER_ID = 1;

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
                return response()->json($validator->errors()->toJson(), Response::HTTP_BAD_REQUEST);
            }
            $user = User::create([
                'nick' => $request->get('nick'),
                'email' => $request->get('email'),
                'password' => bcrypt($request->password),
                'steamUserName' => $request->get('steamUserName'),
            ]);
            $token = JWTAuth::fromUser($user);

            //Add player role by default in normal users
            $user->roles()->attach(self::ROLE_USER_ID);

            Log::info('new user created called ' . $user->nick);
            return response()->json(compact('user', 'token'), Response::HTTP_ACCEPTED);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json(['error' => ' error registering user ' . $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
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
            ], Response::HTTP_ACCEPTED);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json(['error' => ' Error in login ' . $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function logout(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);
        try {
            JWTAuth::invalidate($request->token);
            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully'
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, the user cannot be logged out'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function profile()
    {
        try {
            return response()->json([
                "nick" => auth()->user()->nick,
                "email" => auth()->user()->email,
                "steamUserName" => auth()->user()->steamUserName,
                "account created" => auth()->user()->created_at,
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => ' error in profile user ' . $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
