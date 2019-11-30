<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Command extends Model
{

    protected $fillable = ['submit', 'user_id'];

    //foreign keys:

    //many to many relation
    public function articles()
    {
        return $this->belongsToMany('App\Article', 'articles_cmd');
    }

}
