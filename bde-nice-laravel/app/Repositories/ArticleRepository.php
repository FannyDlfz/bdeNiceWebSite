<?php

namespace App\Repositories;

use App\Article;

class ArticleRepository extends BaseRepository {

    protected $article;

    public function __construct(Article $article)
    {
        $this->model = $article;
    }

    public function getSelected()
    {
        return Article::where('selected', 1)->get();
    }
}
