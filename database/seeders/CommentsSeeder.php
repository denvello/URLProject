<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;

class CommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //$faker = Faker::create('id_ID');
        $faker = Faker::create('en_US');
    	for($i = 1; $i <= 10; $i++){
            DB::table('comments')->insert([
                'user_id' => $faker->numberBetween(1,50),
                //'url_id' => $faker->numberBetween(1,50),
                'url_id' => 1,
                'comment_text' => $faker->sentence(250),
                'created_at'=>now(),
                'updated_at'=>now(),
            ]);
        }
    }
}
