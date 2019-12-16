<?php

namespace App\Repositories;

use App\Article;

class ArticleRepository extends BaseRepository {

    protected $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function getSelected()
    {
        return Article::where('selected', 1)->get();
    }

    public function findAll()
    {
        return Article::all();
    }

    public function sortByOrderedNumber() {

        $articles = Article::all();

        $ordered [$articles->name] = $articles->ordered;

        return sort($ordered);

    }

}
