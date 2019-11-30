<?php


namespace App\Repositories;
use App\Event;

class EventRepository extends BaseRepository {

    protected $event;

    public function __construct(Event $event) {
        $this->model = $event;
    }

    public function getSelected()
    {
        return Event::where('selected', 1)->get();
    }

}
