<?php

namespace App\Services;

use App\Models\Game;
use App\Models\Team;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TeamService
{
    public function getTeamList(): array
    {
        return Team::all()->toArray();
    }

    public function getTeamStatistic(): array
    {
        return Team::query()
            ->select(
                'teams.*',

                DB::raw('SUM(IF(g_first.first_team_id = teams.id, 1, 0)) +
                    SUM(IF(g_second.second_team_id = teams.id, 1, 0)) as all_games'),

                DB::raw('SUM(IF(g_first.first_team_id = teams.id AND
                    g_first.first_team_result > g_first.second_team_result, 1, 0)) +
                    SUM(IF(g_second.second_team_id = teams.id AND
                    g_second.first_team_result < g_second.second_team_result, 1, 0)) as win_games'),

                DB::raw('SUM(IF(g_first.first_team_id = teams.id AND
                    g_first.first_team_result = g_first.second_team_result, 1, 0)) +
                    SUM(IF(g_second.second_team_id = teams.id AND
                    g_second.first_team_result = g_second.second_team_result, 1, 0)) as draw_games'),

                DB::raw('SUM(IF(g_first.first_team_id = teams.id AND
                    g_first.first_team_result < g_first.second_team_result, 1, 0)) +
                    SUM(IF(g_second.second_team_id = teams.id AND
                    g_second.first_team_result > g_second.second_team_result, 1, 0)) as lose_games'),

                DB::raw('SUM(IF(g_first.first_team_id = teams.id, g_first.first_team_result, 0)) +
                    SUM(IF(g_second.second_team_id = teams.id, g_second.second_team_result, 0)) as goals_count')


            )
            ->leftJoin(DB::raw((new Game())->getTable(). ' as g_first'), 'teams.id', '=',
                'g_first.first_team_id')
            ->leftJoin(DB::raw((new Game())->getTable(). ' as g_second'), 'teams.id', '=',
                'g_second.second_team_id')
            ->groupBy('teams.id')
            ->get()
            ->toArray();
    }

    public function addNewTeam(array $team_info): void
    {
        $team = new Team();
        $team->fill($team_info);
        $team->save();
    }

    public function getTeamById(int $team_id): ?Model
    {
        return Team::query()->find($team_id);
    }

    public function updateTeam(int $team_id, array $team_info): void
    {
       $team = Team::query()->find($team_id);

       if(!is_null($team)){
           $team->fill($team_info);
           $team->save();
       }
    }

    public function deleteTeamById(int $team_id): void
    {
        Team::query()->where('id', $team_id)->delete();
    }
}
