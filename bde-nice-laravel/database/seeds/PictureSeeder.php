<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PictureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $field = ['article_id', 'event_id'];

        for($i = 0; $i < 2; $i++)
        {
            for($j = 1; $j <= 100; $j++)
            {
                DB::table('pictures')->insert(
                [
                    'name'                  => $faker->imageUrl(1920, 1080),
                    'extension'             => null,
                    $field[$i]              => $j,
                    $field[$i == 0 ? 1 : 0] => null
                ]);
            }
        }
    }
}
