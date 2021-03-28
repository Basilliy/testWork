<?php

namespace App\Http\Controllers;

use App\Http\Requests\Game\GameStatisticRequest;
use App\Services\GameService;
use App\Services\TeamService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class SystemController extends Controller
{
    protected TeamService $teamService;
    protected GameService $gameService;

    public function __construct(TeamService $teamService, GameService $gameService)
    {
        $this->teamService = $teamService;
        $this->gameService = $gameService;
    }

    public function errorPage(): View
    {
        return view('404');
    }

    public function lastWeek(): JsonResponse
    {
        return response()->json($this->gameService->getLastWeek(), Response::HTTP_OK);
    }

    public function home(GameStatisticRequest $request): View
    {
        return view('home')
            ->with('teams', $this->teamService->getTeamStatistic())
            ->with('weekNumber', $request->week);
    }
}
