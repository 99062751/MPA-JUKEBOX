<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Genre;
use Illuminate\Support\Carbon;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Song>
 */
class SongFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "name" => $this->faker->unique()->name(),
            "artist" => $this->faker->unique()->name(), 
            "genre_id" => Genre::inRandomOrder()->first()->id,
            "duration" => Carbon::now(),
        ];
    }
}
