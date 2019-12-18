<?php


namespace App\Repositories;
use App\Comment;

class CommentRepository extends BaseRepository {

    public function __construct()
    {
        $this->model = new Comment();
    }

    public function findAll()
    {
        return Comment::all();
    }

    public function findByEventId($id)
    {
        return Comment::where('event_id', '=', $id)->orderBy('created_at', 'desc')->get();
    }

    public function findByArticleId($id)
    {
        return Comment::where('article_id', '=', $id)->orderBy('created_at', 'desc')->get();
    }

    public function findByEventPhotoId($id)
    {
        return Comment::where('event_photo_id', '=', $id)->orderBy('created_at', 'desc')->get();
    }

    public function hide($id) {

        $comment = $this->getById($id);

        $comment->hidden = true;

        $comment->save();
    }
}
