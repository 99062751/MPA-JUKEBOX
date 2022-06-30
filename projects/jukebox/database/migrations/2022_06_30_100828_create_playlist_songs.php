<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('playlist_song', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('playlist_id')->unsigned()->default(1);
            $table->bigInteger('song_id')->unsigned()->default(1);

            $table->foreign('playlist_id')->references('id')->on("playlists");
            $table->foreign('song_id')->references('id')->on("songs");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('playlist_song');
    }
};
