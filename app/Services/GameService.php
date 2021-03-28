<?php

namespace App\Services;

use App\Models\Game;

class GameService
{
    private TeamService $teamService;

    public function __construct(TeamService $teamService)
    {
        $this->teamService = $teamService;
    }

    /**
     * @return array
     */
    public function getGamesList(): array
    {
        return Game::all()->toArray();
    }

    /**
     * @throws \Exception
     */
    public function playGames(): void
    {
        $teams = $this->teamService->getTeamList();

        if(count($teams) < 2) {
            throw new \Exception("low teams count");
        }

        $currentWeek = $this->getLastWeek() + 1;

        $games = [];

        foreach ($teams as $exitTeam) {
            foreach ($teams as $guestsTeam) {

                if ($exitTeam['id'] !== $guestsTeam['id']) {
                    $games[] = [
                        'first_team_id' => $exitTeam['id'],
                        'first_team_result' => mt_rand ( 0, 5),
                        'second_team_id' => $guestsTeam['id'],
                        'second_team_result' => mt_rand ( 0, 5),
                        'game_week' => $currentWeek
                    ];
                }

            }
        }

        Game::query()->insert($games);
    }

    /**
     * @param int|null $weekNumber
     * @return array
     */
    public function getMatchResult(int $weekNumber = null): array
    {
        $lastWeek = $weekNumber ?? $this->getLastWeek();

        return Game::query()->where('game_week', $lastWeek)->get()->toArray();
    }

    /**
     * @param array $game_info
     */
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

    public function getLastWeek(): int
    {
        $lastWeek = Game::query()->orderBy('id', 'desc')->limit(1)->first();
        return is_null($lastWeek) ? 1 : $lastWeek->game_week;
    }
}
