<?php

namespace App\Repositories;

use App\Article;

class ArticleRepository extends BaseRepository {

    protected $model;

    public function __construct()
    {
        $this->model = new Article;
    }

    public function getSelected()
    {
        return Article::where('selected', 1)->get();
    }
    public function findAll()
    {
        return Article::all();
    }
}
