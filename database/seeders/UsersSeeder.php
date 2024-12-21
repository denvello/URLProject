<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
 
    	for($i = 1; $i <= 50; $i++){
            DB::table('users')->insert([
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => $faker->password,
                
            ]);
        }
    }
}
