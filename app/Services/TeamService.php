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

    public function getTeamStatistic(int $weekNumber = null): array
    {
        $teams = Team::query()->get()->toArray();

        $games = Game::query()
            ->when($weekNumber, static function($query, $weekNumber) {
                return $query->where('game_week', '<=', $weekNumber);
            })
            ->get()->toArray();

        foreach ($teams as &$team) {
            $team['all_games'] = 0;
            $team['goals_count'] = 0;
            $team['win_games'] = 0;
            $team['draw_games'] = 0;
            $team['lose_games'] = 0;

            foreach ($games as $game) {
                if ($game['first_team_id'] === $team['id']) {
                    $team['all_games'] = isset($team['all_games']) ? $team['all_games'] + 1 : 1;
                    $team['goals_count'] = isset($team['goals_count']) ?
                        $team['goals_count'] + $game['first_team_result'] :
                        $game['first_team_result'];

                    if ($game['first_team_result'] > $game['second_team_result']) {
                        $team['win_games'] = isset($team['win_games']) ? $team['win_games'] + 1 : 1;
                    }

                    if ($game['first_team_result'] === $game['second_team_result']) {
                        $team['draw_games'] = isset($team['draw_games']) ? $team['draw_games'] + 1 : 1;
                    }

                    if ($game['first_team_result'] < $game['second_team_result']) {
                        $team['lose_games'] = isset($team['lose_games']) ? $team['lose_games'] + 1 : 1;
                    }
                }

                if ($game['second_team_id'] === $team['id']) {
                    $team['all_games'] = isset($team['all_games']) ? $team['all_games'] + 1 : 1;
                    $team['goals_count'] = isset($team['goals_count']) ?
                        $team['goals_count'] + $game['second_team_result'] :
                        $game['second_team_result'];

                    if ($game['second_team_result'] > $game['first_team_result']) {
                        $team['win_games'] = isset($team['win_games']) ? $team['win_games'] + 1 : 1;
                    }

                    if ($game['second_team_result'] === $game['first_team_result']) {
                        $team['draw_games'] = isset($team['draw_games']) ? $team['draw_games'] + 1 : 1;
                    }

                    if ($game['second_team_result'] < $game['first_team_result']) {
                        $team['lose_games'] = isset($team['lose_games']) ? $team['lose_games'] + 1 : 1;
                    }
                }
            }

        }

     return $teams;
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
