<?php

namespace App\Http\Controllers;

use App\Services\TeamService;
use Illuminate\Http\Request;

class SystemController extends Controller
{
    protected TeamService $teamService;

    public function __construct(TeamService $teamService)
    {
        $this->teamService = $teamService;
    }

    public function errorPage()
    {
        return view('404');
    }

    public function home()
    {
        return view('home')->with('teams', $this->teamService->getTeamStatistic());
    }
}
