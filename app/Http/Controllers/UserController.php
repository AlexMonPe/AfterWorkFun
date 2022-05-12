<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    const ROLE_ADMIN_ID = 2;

    public function getAllUsers()
    {
        try {
            $users = User::get()->toArray();

            return $users;
        } catch (\Throwable $th) {
            Log::error('Error getting all users ' . $th->getMessage());
            return response()->json([
                "name" => $th->getMessage(),
                "error" => 'Error getting all users '
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateUserProfile (Request $request, $id) {
        try {
            $validator = Validator::make($request->all(), [
                'nick' => 'string',
                'email' => 'email',
                'steamUserName' => 'string',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
            }

            $userId = auth()->user()->id;

            $profile = User::where('id', $id)->where('id', $userId)->first();

            if (empty($profile)) response()->json(["error" => "User Profile not found"],Response::HTTP_NOT_FOUND);

            if (isset($request->nick)) $profile->nick = $request->nick;
            if (isset($request->email)) $profile->email = $request->email;
            // if (isset($request->password)) $profile->password = bcrypt($request->password);
            if (isset($request->steamUserName)) $profile->steamUserName = $request->steamUserName;

            $profile->save();

            return response()->json(["data" => $profile, "success" => "Profile updated"], Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Error updating profile ' . $th->getMessage());
            return response()->json([
                "name" => $th->getMessage(),
                "error" => 'Error updating profile'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteUser($id){
        
        try {
            $user = User::where('id', $id)->first();
            
            if (empty($user)) return response()->json(["error" => "User not found"], Response::HTTP_NOT_FOUND);

            $user->delete();

            return response()->json(["success" => "Deleted user => " . $user->nick], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                "name" => $th->getMessage(),
                "error" => 'Error deleting user '
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function createAdmin($id){
        try {
            Log::info('createAdmin');

            $user = User::find($id);

            $user->roles()->attach(self::ROLE_ADMIN_ID);

            return response()->json(['success' => 'User with id: '.$id.' '.' is admin'], Response::HTTP_ACCEPTED);

        } catch (\Throwable $th) {
            Log::error('createAdmin'.$th->getMessage());
            return response()->json(['error' => 'Error creating Admin'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
