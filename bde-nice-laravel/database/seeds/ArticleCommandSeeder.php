<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticleCommandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 50; $i++)
        {
            $numbers = range(1, 100);
            shuffle($numbers);
            DB::table('articles_cmd')->insert(array(
               'article_id' => $numbers[0],
               'command_id'     => $i
            ));
        }
    }
}
