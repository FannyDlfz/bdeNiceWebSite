<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventPhoto extends Model {

    protected $fillable = ['event_id', 'user_id', 'name', 'description', 'extension'];

    //foreign keys:

    //one to many relation -weak side-
    public function users(){

        return $this->belongsTo('App\Users');
    }

    public function events(){

        return $this->belongsTo('App\Events');
    }

    //one to many relation -strong side-
    public function comments(){

        return $this->hasMany('App\Comments');
    }

}
