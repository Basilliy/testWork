<?php

namespace App\Http\Controllers;

use App\Http\Requests\Game\CreateGameRequest;
use App\Http\Requests\Game\GameStatisticRequest;
use App\Services\GameService;
use App\Services\TeamService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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

    /**
     * @throws \Exception
     */
    public function play(): JsonResponse
    {
        $this->gameService->playGames();

        return response()->json($this->teamService->getTeamStatistic(), Response::HTTP_OK);
    }

    public function lastResult(GameStatisticRequest $request): JsonResponse
    {

        return response()->json($this->gameService->getMatchResult($request->week), Response::HTTP_OK);
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
