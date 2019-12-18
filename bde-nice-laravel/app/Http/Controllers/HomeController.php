<?php


namespace App\Http\Controllers;

use App\Repositories\ArticleRepository;
use App\Repositories\EventRepository;

class HomeController extends Controller
{
    protected $eventRepository;
    protected $articleRepository;

    public function __construct(EventRepository $eventRepository, ArticleRepository $articleRepository)
    {
        $this->eventRepository   = $eventRepository;
        $this->articleRepository = $articleRepository;
    }

    /**
     * Display main page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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
