<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use Faker\Factory as Faker;


class TicketsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker::create();


        $numberOfTickets = 10;

        for ($i = 0; $i < $numberOfTickets; $i++) {
            DB::table('tickets')->insert([
                'name' => $faker->word,
                'display_name' => $faker->sentence,
                'status' => $faker->boolean,
                'description' => $faker->sentence,
                'display_description' => $faker->sentence,
                'weekday_price' => $faker->randomFloat(2, 10, 100),
                'weekend_price' => $faker->randomFloat(2, 10, 100),
                'start_date_time' => $faker->dateTimeBetween('-1 week', '+1 week'),
                'end_date_time' => $faker->dateTimeBetween('+1 week', '+2 weeks'),
                'play_time' => $faker->time(),
                'advance_payment' => $faker->randomNumber(2),
                'tax' => $faker->randomNumber(2),
                'max_sale_per_order' => $faker->randomNumber(),
                'min_sale_per_order' => $faker->randomNumber(),
                'pos' => $faker->boolean,
                'one_bill_per_item' => $faker->boolean,
                'sell_and_register_customer' => $faker->boolean,
                'order_locked' => $faker->boolean,
                'custom_price' => $faker->boolean,
                'print_as_ticket' => $faker->boolean,
                'print_tc_on_ticket' => $faker->boolean,
                'btn_img' => $faker->imageUrl(),
                'location_id' => $faker->numberBetween(1, 2),
                'category_ids' => $faker->numberBetween(1, 2),
                'term_and_condition_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
