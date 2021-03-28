<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $table = 'teams_games';

    protected $fillable = [
        'first_team_id',
        'first_team_result',
        'second_team_id',
        'second_team_result',
        'game_week'
    ];

    protected $with = [
        'first_team',
        'second_team'
    ];

    public function first_team()
    {
        return $this->hasOne(Team::class, 'id', 'first_team_id');
    }

    public function second_team()
    {
        return $this->hasOne(Team::class, 'id', 'second_team_id');
    }
}
