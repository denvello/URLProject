<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;

class CommentRepliesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
 
    	for($i = 1; $i <= 50; $i++){
            DB::table('comment_replies')->insert([
                //'comment_id' => $faker->numberBetween(1,50),
                'user_id' => $faker->numberBetween(1,50),
                'reply_text' => $faker->sentence(50),
                
            ]);
        }
    }
}

