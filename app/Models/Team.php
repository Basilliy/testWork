<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $table = 'teams';

    protected $fillable = [
        'name',
        'iso'
    ];

//    protected $with = [
//      //  'goal_count'
//    ];
//
//    public function goal_count()
//    {
//        return $this->hasMany(Game::class, 'first_team_id', 'id');
//    }
}
