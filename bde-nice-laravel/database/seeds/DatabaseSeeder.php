<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ArticlesTableSeeder           ::class);
        $this->call(ArticleCategorySeeder         ::class);
        $this->call(CommandsTableSeeder           ::class);
        $this->call(EventsTableSeeder             ::class);
        $this->call(PictureSeeder                 ::class);
        $this->call(EventPhotoSeeder              ::class);
        $this->call(CommentsTableSeeder           ::class);
        $this->call(EventCategorySeeder           ::class);
        $this->call(EventCategoryCategorySeeder   ::class);
        $this->call(ArticleCommandSeeder          ::class);
        $this->call(ArticleCategoryCategorySeeder ::class);
    }
}
