<?php

namespace App\Http\Controllers;

use App\Models\Party;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class PartyController extends Controller
{
    public function createParty(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'game_id' => 'required|int'
            ]);

            if ($validator->fails()) return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);

            $newParty = new Party();

            $newParty->name = $request->name;
            $newParty->game_id = $request->game_id;
            $newParty->save();

            $userId = auth()->user()->id;

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
