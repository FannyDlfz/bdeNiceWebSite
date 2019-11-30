<?php


namespace App\Repositories;


use App\Subscription;

class SubscriptionRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new Subscription();
    }

    public function is_user_subscribed($user_id, $event_id)
    {
        return Subscription::where([['user_id', '=', $user_id], ['event_id', '=', $event_id]])->count() > 0;
    }

    public function get_subscriptions($event_id)
    {
        return Subscription::where('event_id', '=', $event_id)->get();
    }

    public function unsubscribe($user_id, $event_id)
    {
        return Subscription::where([['user_id', '=', $user_id], ['event_id', '=', $event_id]])->delete();
    }
}
