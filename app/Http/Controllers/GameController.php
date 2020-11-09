<?php

namespace App\Http\Controllers;

use App\Http\Requests\Game\CreateGameRequest;
use App\Services\GameService;
use App\Services\TeamService;
use Illuminate\Http\Request;

class GameController extends Controller
{
    protected GameService $gameService;
    protected TeamService $teamService;

    public function __construct(GameService $gameService, TeamService $teamService)
    {
        $this->gameService = $gameService;
        $this->teamService = $teamService;
    }

    public function index()
    {
        return view('game.index')->with('games', $this->gameService->getGamesList());
    }

    public function add()
    {
        return view('game.add')->with('teams', $this->teamService->getTeamList());
    }

    public function create(CreateGameRequest $request)
    {
        $this->gameService->addNewGame($request->all());

        return redirect(route('game.list'));
    }

    public function delete($id)
    {
        $this->gameService->deleteGameById($id);

        return redirect(route('game.list'));
    }
}
