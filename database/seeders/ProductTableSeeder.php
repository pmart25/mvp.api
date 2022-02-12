<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class ProductTableSeeder extends Seeder
{


    //https://www.toptal.com/laravel/restful-laravel-api-tutorial
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        // Let's truncate our existing records to start from scratch.
        //Product::truncate();

        $faker = \Faker\Factory::create();
        
       // And now, let's create a few articles in our database:
                for ($i = 0; $i < 10; $i++) {
                    Product::create([
                        'productName' => $faker->word,
                        'amountAvailable' => $faker->randomDigit,
                        'sellerId' => $faker->randomDigit,
                    ]);
                }
    }
}
