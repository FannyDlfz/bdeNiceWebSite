<?php

namespace App;

use App\Repositories\APIModelRepository;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $fillable = ['user_id', 'event_id', 'article_id', 'text', 'event_photo_id'];

    //foreign keys:

    //one to many relations -weak side-
    public function article() {

        return $this->belongsTo('App\Article');
    }

    public function eventPhoto(){

        return $this->belongsTo('App\EventPhoto');
    }

    public function event(){

        return $this->belongsTo('App\Event');
    }

    public function user()
    {
        $userRepository = new APIModelRepository('App\User', '/api/users');

        $user = $userRepository->find(array('id' => $this->user_id));

        return $user;
    }


}
