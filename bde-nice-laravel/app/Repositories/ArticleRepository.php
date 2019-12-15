<?php

namespace App\Repositories;

use App\Article;

class ArticleRepository extends BaseRepository {

    protected $article;

    public function __construct()
    {
        $this->model = new Article;
    }

    public function getSelected()
    {
        return Article::where('selected', 1)->get();
    }
}
