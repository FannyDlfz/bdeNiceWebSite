<?php

namespace App\Http\Controllers;

use App\Repositories\ArticleRepository;
use App\Repositories\EventCatRepository;
use App\Repositories\EventPhotoRepository;
use App\Repositories\EventRepository;
use App\Repositories\PictureRepository;
use Illuminate\Http\Request;

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

    public function index()
    {
        return view('admin.dashboard');
    }

    public function index_events()
    {
        return view('admin.events.index');
    }

    public function events_list_ajax()
    {
        $events = $this->eventRepository->getPaginate(20);
        $links = $events->render();

        return response()->json(compact('links', 'events'));
    }

    public function index_articles()
    {
        return view('admin.articles.index');
    }

    public function articles_list_ajax()
    {
        $articles = $this->articleRepository->getPaginate(20);
        $links = $articles->render();

        return response()->json(compact('links', 'articles'));
    }
}
