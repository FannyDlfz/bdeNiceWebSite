<?php


namespace App\Http\Controllers;


use App\Http\Resources\ArticleResource;
use App\Http\Resources\EventResource;
use App\Repositories\ArticleRepository;
use App\Repositories\EventPhotoRepository;
use App\Repositories\EventRepository;
use App\Repositories\PictureRepository;

class HomeController extends Controller
{
    protected $eventRepository;
    protected $articleRepository;

    public function __construct(EventRepository $eventRepository, ArticleRepository $articleRepository)
    {
        $this->eventRepository   = $eventRepository;
        $this->articleRepository = $articleRepository;
    }

    public function index()
    {
        $events   = $this->eventRepository->findAll();
        $articles = $this->articleRepository->findAll();

        $ordered = [];

        foreach ($articles as $article) {
            array_push($ordered, $article);
        }

        usort($ordered, function($a, $b)
        {
            return $a->ordered < $b->ordered;
        });

        return view('home', compact('articles', 'events','ordered'));
    }
}
