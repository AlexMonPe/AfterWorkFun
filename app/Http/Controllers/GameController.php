<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function getAllGames()
    {
        $games = Game::get()->toArray();

        foreach ($games as $game) {
            return $game->name;
        }
    }
}
