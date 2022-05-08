<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

   
}
