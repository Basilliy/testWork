<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams_games', function (Blueprint $table) {
            $table->id();

            $table->integer('first_team_id')->unsigned();
            $table->foreign('first_team_id')
                ->references('id')
                ->on('teams')
                ->onDelete('cascade');
            $table->integer('first_team_result');

            $table->integer('second_team_id')->unsigned();
            $table->foreign('second_team_id')
                ->references('id')
                ->on('teams')
                ->onDelete('cascade');
            $table->integer('second_team_result');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
}
