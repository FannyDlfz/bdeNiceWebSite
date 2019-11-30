<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleCategory extends Model {

    protected $fillable = ['name'];

    public $timestamps = false;

    public function articles() {

        //foreign key:

        //many to many relation
        return $this->belongsToMany('App\Article', 'articles_associated');
    }
}
