<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticleCategoryCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 100; $i++)
        {
            $numbers = range(1, 10);
            shuffle($numbers);
            $n = rand(1, 3);
            for($j = 1; $j <= $n; $j++)
            {
                DB::table('articles_associated')->insert(array(
                   'article_id'          => $i,
                   'article_category_id' => $numbers[$j]
                ));
            }
        }
    }
}
