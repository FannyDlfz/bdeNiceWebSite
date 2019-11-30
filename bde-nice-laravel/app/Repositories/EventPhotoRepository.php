<?php


namespace App\Repositories;
use App\EventPhoto;

class EventPhotoRepository extends BaseRepository {

    protected $eventPhoto;

    public function __construct(EventPhoto $eventPhoto) {
        $this->model = $eventPhoto;
    }
    public function findByEventId($id) {

        return EventPhoto::where('event_id', '=', $id)->get();
    }

    public function findAll()
    {
        return EventPhoto::all();
    }

}
