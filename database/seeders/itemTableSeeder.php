<?php

namespace Database\Seeders;

use App\Models\item;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class itemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker= Faker::create();
        foreach (range(1, 10) as $index) {
            DB::table('items')->insert([
                'name'=> $faker->unique()->company(),
                'quantity'=> $faker->biasedNumberBetween($min = 10, $max = 80, $function = 'sqrt'),
                'sale_price'=> $faker->biasedNumberBetween($min = 0, $max = 90, $function = 'sqrt'),
                'total_price'=> $faker->biasedNumberBetween($min = 25, $max = 500, $function = 'sqrt')
            ]);
        }
    }
}
