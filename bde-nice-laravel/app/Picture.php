<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model {

    protected $fillable = ['name', 'article_id', 'event_id', 'extension'];

    //foreign keys:

    //one to many relations -weak side-
    public function article() {
        return $this->belongsTo('App\Article');
    }

    public function event() {
        return $this->belongsTo('App\Event');
    }
}
