<?php


namespace App\Repositories;

use App\Article;
use App\ArticleCategory;

class ArticleCatRepository extends BaseRepository {

    public function __construct()
    {
        $this->model = new ArticleCategory();
    }

    public function findAll()
    {
        return ArticleCategory::all();
    }

    public function storeRelation(Article $article, array $categories)
    {
        foreach($categories as $category)
        {
            $article->articleCategories()->attach($category);
        }
    }

    public function updateRelation(Article $article, array $categories) {

        foreach ($categories as $category) {
            $article->articleCategories()->sync($category);
        }
    }

    public function destroyRelation(Article $article, array $categories) {
        foreach ($categories as $category) {
            $article->articleCategories()->detach($category);
        }
    }

    public function findByEventId($id) {

        return ArticleCatRepository::where('event_id', '=', $id)->get();
    }

}
