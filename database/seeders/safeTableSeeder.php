<?php

namespace Database\Seeders;

use App\Models\safe;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class safeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     $faker= Faker::create();
     foreach(range(1,6) as $index){
         DB::table('safes')->insert([
             'name'=> $faker->unique()->creditCardType(),
             'money_amount'=> $faker->biasedNumberBetween($min = 10, $max = 2000, $function = 'sqrt')
         ]);
     }
    }
}
