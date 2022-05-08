<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class GameController extends Controller
{
    public function getAllGames()
    {
        try {
            $games = Game::get()->toArray();

            foreach ($games as $game) {
                return $game->name;
            }
        } catch (\Throwable $th) {
            Log::error('Error getting all games ' . $th->getMessage());
            return response()->json([
                "name" => $th->getMessage(),
                "error" => 'Error getting all games '
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function createGame(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
            'name' => 'required|string',
        ]);

        if ($validator->fails()) return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);

        $newGame = new Game();

        $newGame->name = $request->name;

        $newGame->save();

        return response()->json(["success" => "Game created -> ".$newGame->name ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            Log::error('Error creating game ' . $th->getMessage());
            return response()->json([
                "name" => $th->getMessage(),
                "error" => 'Error creating game '
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        

    }
}
