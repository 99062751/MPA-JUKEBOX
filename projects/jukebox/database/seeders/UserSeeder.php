<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $userdata= [
            [
                "name" => "aapje",
                "email" => "aapjeaap@gmail.com",
                "password" => bcrypt("aapje1234")
            ]
        ];

        foreach($userdata as $data => $value){
            User::create($value);
        }
    }
}
