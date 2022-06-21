<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;


class SongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table("songs")->insert([
            "song_name" => Str::random(10),
            "artist" => Str::random(10),
            "song_type" => Str::random(10),
            "song_duration" => Carbon::now(),
        ]);
    }
    
}
