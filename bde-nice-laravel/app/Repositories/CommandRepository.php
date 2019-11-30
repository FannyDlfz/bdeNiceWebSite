<?php


namespace App\Repositories;

use App\Command;

class CommandRepository extends BaseRepository {

    protected $command;

    public function __construct(Command $command) {
        $this->model = $command;
    }

    public function getByUserId($id)
    {
        return $this->model->where('user_id', '=', $id)->first();
    }

    public function storeRelation($user_id, $article_id)
    {
        $basket = $this->getByUserId($user_id);
        if($basket == null)
            $basket = $this->store(array('submit' => false, 'user_id' => $user_id));

        $basket->articles()->attach($article_id);
    }

    public function destroyRelation($user_id, $article_id)
    {
        $basket = $this->getByUserId($user_id);
        if($basket != null)
            $basket->articles()->detach($article_id);
    }
}
