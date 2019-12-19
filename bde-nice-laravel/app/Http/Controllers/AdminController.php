<?php

namespace App\Http\Controllers;

use App\Repositories\ArticleRepository;
use App\Repositories\EventRepository;

class AdminController extends Controller
{
    const NB_PER_PAGE = 15;

    protected $eventRepository;
    protected $articleRepository;

    public function __construct(EventRepository $eventRepository, ArticleRepository $articleRepository)
    {
        $this->eventRepository = $eventRepository;
        $this->articleRepository = $articleRepository;
    }

    /**
     * Display general admin page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        if (!session()->has('user') || (session('role') != 4)) {
            return 'Vous devez être connecté et avoir le statut Admin pour accéder à cette page';
        }

        return view('admin.dashboard');
    }

    /**
     * Display all events on admin page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index_events()
    {
        if (!session()->has('user') || (session('role') != 4)) {
            return 'Vous devez être connecté et avoir le statut Admin pour accéder à cette page';
        }

        return view('admin.events.index');
    }

    /**
     * Fill events with Ajax
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function events_list_ajax()
    {
        $events = $this->eventRepository->getPaginate(self::NB_PER_PAGE);
        $links = $events->render();

        return response()->json(compact('links', 'events'));
    }

    /**
     * Display all articles admin page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index_articles()
    {
        if (!session()->has('user') || (session('role') != 4)) {
            return 'Vous devez être connecté et avoir le statut Admin pour accéder à cette page';
        }

        return view('admin.articles.index');
    }

    /**
     * Fill articles with Ajax
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function articles_list_ajax()
    {
        $articles = $this->articleRepository->getPaginate(20);
        $links = $articles->render();

        return response()->json(compact('links', 'articles'));
    }
}
