<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\Song;
use \App\Models\Genre;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        // gebruikt factories song en genre
        Genre::factory(6)->create();
        Song::factory(10)->create();

        $this->call(PlaylistsSeeder::class);

        


        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
