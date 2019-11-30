<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventCategory extends Model {

    protected $fillable = ['name'];

    public $timestamps = false;

    //foreign key:

    //many to many relation
    public function events() {
    return $this->belongsToMany('App\Event', 'events_associated');
    }

}
