<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model {

    protected $fillable = ['name', 'price', 'description'];

    //foreign keys:

    //many to many relation
    public function commands() {
        return $this->belongsToMany('App\Command', 'articles_cmd');
    }

    public function articleCategories() {
        return $this->belongsToMany('App\ArticleCategory', 'articles_associated');
    }

    //one to many relation -strong side-
    public function pictures() {
        return $this->hasMany('App\Picture');
    }

    public function comments() {
        return $this->hasMany('App\Comment');
    }
}
