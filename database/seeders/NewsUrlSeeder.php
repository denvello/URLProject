<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;

class NewsUrlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('en_US');
        //$faker = Faker::create('id_ID');
        for($i = 1; $i <= 50; $i++){
            DB::table('news_url')->insert([
                //'user_id' => $faker->numberBetween(1,50),
                'url' => $faker->domainName . '/blogs/' . $faker->word,
                //'url' => $faker->numberBetween(1,50),
                'title' => $faker->sentence(5),
                'news_user_id' => $faker->numberBetween(1,50)
            ]);
        }
        
    }
}
