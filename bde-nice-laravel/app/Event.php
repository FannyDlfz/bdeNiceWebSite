<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['name', 'scheduled', 'recurrence', 'price', 'description', 'begin_at', 'end_at', 'user_id'];

    //foreign keys:

    //many to many relations
    public function users() {
        return $this->belongsToMany('App\User');
    }

    public function pictures(){

        return $this->hasMany('App\Picture');
    }

    public function eventCategories(){

        return $this->belongsToMany('App\EventCategory', 'events_associated');
    }

    //one to many relations -strong side-
    public function eventPhotos() {

        return $this->hasMany('App\EventPhoto');
    }

    public function comments(){

        return $this->hasMany('App\Comment');
    }



}
