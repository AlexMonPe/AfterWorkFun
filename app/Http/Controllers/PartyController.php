<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Party;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class PartyController extends Controller
{
    public function getAllParties()
    {
        try {
            $parties = Party::get()->toArray();

            return $parties;
        } catch (\Throwable $th) {
            Log::error('Error getting all parties ' . $th->getMessage());
            return response()->json([
                "name" => $th->getMessage(),
                "error" => 'Error getting all parties '
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getPartiesByUserId()
    {
        try {
            $userId = auth()->user()->id;

            //$parties = Party::where('user_id', $userId)->get()->toArray();

            $parties = User::find($userId)->users_parties;

            return $parties;
        } catch (\Throwable $th) {
            Log::error('Error getting all parties by id user' . $th->getMessage());
            return response()->json([
                "name" => $th->getMessage(),
                "error" => 'Error getting all parties by id user '
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getPartiesByGame($id)
    {
        try {
            //without relation
            //$parties = Party::where('game_id', $id)->get()->toArray();

            //with relation
            $parties = Game::find($id)->parties;

            return $parties;
        } catch (\Throwable $th) {
            Log::error('Error getting all parties by game ' . $th->getMessage());
            return response()->json([
                "name" => $th->getMessage(),
                "error" => 'Error getting all parties by game '
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function createParty(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'game_id' => 'required|int',
            ]);

            if ($validator->fails()) return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);

            $userId = auth()->user()->id;

            $newParty = new Party();

            $newParty->name = $request->name;
            $newParty->game_id = $request->game_id;
            $newParty->user_id = $userId;

            $newParty->save();

            $newParty->users_parties()->attach($userId);

            return response()->json(["success" => "Party created -> " . $newParty->name], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            Log::error('Error creating party ' . $th->getMessage());

            return response()->json([
                "name" => $th->getMessage(),
                "error" => 'Error creating game '
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateParty(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'string',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
            }

            $userId = auth()->user()->id;

            $party = Party::where('id', $id)->where('user_id', $userId)->first();

            if (empty($party)) return response()->json(["error" => "Party not found"], Response::HTTP_NOT_FOUND);

            if (isset($request->name)) $party->name = $request->name;

            $party->save();

            return response()->json(["success" => "Updated party => " . $party->name], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                "name" => $th->getMessage(),
                "error" => 'Error updating party '
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteParty($id)
    {
        try {
            $userId = auth()->user()->id;

            $party = Party::where('id', $id)->where('user_id', $userId)->first();

            if (empty($party)) return response()->json(["error" => "Party not found"], Response::HTTP_NOT_FOUND);

            $party->delete();

            return response()->json(["success" => "Deleted party => " . $party->name], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                "name" => $th->getMessage(),
                "error" => 'Error deleting party '
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    //join $id party 

    public function joinParty($id)
    {
        try {
            $userId = auth()->user()->id;

            $user = User::find($userId);

            $parties = $user->users_parties;
        
            foreach ($parties as $party) {

                if ($id == $party->pivot->party_id && $userId == $party->pivot->user_id) {
                    return 'Can\'t join again';
                }
            }
            $user->users_parties()->attach($id);
            return response()->json(["success" => "Joined party success"], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                "name" => $th->getMessage(),
                "error" => 'Error joining party '
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    //left party with $id

    public function leaveParty($id)
    {
        try {
            $userId = auth()->user()->id;

            $party = Party::where('id', $id)->first();

            $party->users_parties()->detach($userId);

            return response()->json(["success" => "you left party => " . $party->name], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                "name" => $th->getMessage(),
                "error" => 'Error joining party '
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
