<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Playlist;

class PlaylistsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $Data= [
            [
                "name" => "Apenplaylist",
                // user id word gekoppelt aan user met naam aapje
                "user_id" => User::where("name", "aapje")->first()->id,
            ]
        ];

        foreach($Data as $data => $value){
            Playlist::create($value);
        }
    }
}
