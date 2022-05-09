<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\HasApiTokens;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nick',
        'email',
        'password',
        'steamUserName',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function updateUserProfile (Request $request, $id) {
        try {
            $validator = Validator::make($request->all(), [
                'nick' => 'string',
                'email' => 'email',
                'password' => 'string',
                'steamUserName' => 'string',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
            }

            $userId = auth()->user()->id;

            $profile = User::where('id', $id)->where('id_user', $userId)->first();

            if (empty($profile)) response()->json(["error" => "User Profile not found"],Response::HTTP_NOT_FOUND);

            if (isset($request->nick)) $profile->name = $request->name;
            if (isset($request->email)) $profile->email = $request->email;
            if (isset($request->password)) $profile->password = bcrypt($request->password);
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
}
