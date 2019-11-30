<?php


namespace App\Repositories;

use App\Event;
use App\EventCategory;


class EventCatRepository extends BaseRepository {

    public function __construct()
    {
        $this->model = new EventCategory();
    }

    public function findAll()
    {
        return EventCategory::all();
    }

    public function storeRelation(Event $event, array $categories) {
        foreach ($categories as $category) {
            $event->eventCategories()->attach($category);
        }
    }

    public function updateRelation(Event $event, array $categories) {
        foreach ($categories as $category) {
            $event->eventCategories()->sync($category);
        }
    }
    public function destroyRelation(Event $event, array $categories) {
        foreach ($categories as $category) {
            $event->eventCategories()->detach($category);
        }
    }
}
