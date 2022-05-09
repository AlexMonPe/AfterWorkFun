<?php

namespace App\Http\Controllers;

use App\Models\Party;
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

    public function createParty(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'game_id' => 'required|int',
                'user_id' => 'required|int'
            ]);

            if ($validator->fails()) return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);

            $userId = auth()->user()->id;

            $newParty = new Party();

            $newParty->name = $request->name;
            $newParty->game_id = $request->game_id;
            $newParty->user_id = $userId;


            $newParty->save();

            

            $newParty->user()->attach($userId);

            return response()->json(["success" => "Party created -> " . $newParty->name], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            Log::error('Error creating game ' . $th->getMessage());

            return response()->json([
                "name" => $th->getMessage(),
                "error" => 'Error creating game '
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
