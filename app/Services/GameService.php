<?php

namespace App\Services;

use App\Models\Game;

class GameService
{
    public function getGamesList()
    {
        return Game::all()->toArray();
    }

    public function addNewGame(array $game_info): void
    {
        $game = new Game();
        $game->fill($game_info);
        $game->save();
    }

    public function deleteGameById(int $id)
    {
        Game::query()->where('id', $id)->delete();
    }
}
