<?php

namespace App\Http\Controllers;

use App\Http\Requests\Team\CreateTeamRequest;
use App\Http\Requests\Team\UpdateTeamRequest;
use App\Services\TeamService;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    protected TeamService $teamService;

    public function __construct(TeamService $teamService)
    {
        $this->teamService = $teamService;
    }
    public function index()
    {
        return view('team.index')->with('teams', $this->teamService->getTeamList());
    }

    public function add()
    {
        return view('team.add');
    }

    public function create(CreateTeamRequest $request)
    {

        $this->teamService->addNewTeam($request->all());

        return redirect(route('team.list'));
    }

    public function edit($id)
    {
        $team = $this->teamService->getTeamById($id);

        return is_null($team) ? redirect(route('error')) : view('team.edit')->with('team', $team->toArray());
    }

    public function update(UpdateTeamRequest $request)
    {
        $this->teamService->updateTeam($request->id, $request->all());

        return redirect(route('team.list'));
    }

    public function delete($id)
    {
        $this->teamService->deleteTeamById($id);

        return redirect(route('team.list'));
    }
}
