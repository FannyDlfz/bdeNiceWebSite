<?php

namespace App\Http\Controllers;

use App\Event;
use App\Gestion\FileUploadGestion;
use App\Gestion\SlugGestion;
use App\Like;
use App\Mail\reportMail;
use App\Repositories\APIModelRepository;
use App\Repositories\CommentRepository;
use App\Repositories\EventRepository;
use App\Repositories\EventCatRepository;
use App\Repositories\PictureRepository;
use App\Repositories\EventPhotoRepository;

use App\Picture;

use App\Http\Requests\EventCreateRequest;
use App\Http\Requests\EventUpdateRequest;

use App\Repositories\SubscriptionRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EventController extends Controller {

    const NB_PER_PAGE = 9;

    protected $eventRepository;
    protected $pictureRepository;
    protected $eventPhotoRepository;
    protected $eventCatRepository;
    protected $commentRepository;
    protected $userRepository;
    protected $subscriptionRepository;

    public function __construct(EventRepository         $eventRepository,
                                PictureRepository       $pictureRepository,
                                EventPhotoRepository    $eventPhotoRepository,
                                EventCatRepository      $eventCatRepository,
                                CommentRepository       $commentRepository,
                                SubscriptionRepository  $subscriptionRepository)
    {
        $this->eventRepository          =   $eventRepository;
        $this->pictureRepository        =   $pictureRepository;
        $this->eventPhotoRepository     =   $eventPhotoRepository;
        $this->eventCatRepository       =   $eventCatRepository;
        $this->commentRepository        =   $commentRepository;
        $this->userRepository           =   new APIModelRepository('App\User', '/api/users');
        $this->subscriptionRepository   =   $subscriptionRepository;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        $events = $this->eventRepository->getPaginate(self::NB_PER_PAGE);
        $links = $events->render();
        $eventCategories = $this->eventCatRepository->findAll();

        return view('events.index', compact('events','links', 'eventCategories'));
    }

    /**
     * Subscribe user to an event
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function subscribe($id)
    {
        if (!session()->has('user')) {
            return 'Vous devez être connecté pour participer à un évènement';
        }
        $this->subscriptionRepository->store(array('user_id' => session('user'), 'event_id' => $id));
        return redirect('events/' . $id);
    }

    /**
     * Unsubscribe User from the event
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function unsubscribe($id)
    {
        $this->subscriptionRepository->unsubscribe(session('user'), $id);
        return redirect('events/' . $id);
    }

    /**
     * Get all Subscribed users
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSubUsers($id) {
        if (!session()->has('user') || (session('role') != 4) || session('role') != 2) {
            return 'Vous devez être connecté et avoir le statut Admin pour accéder à cette page';
        }

        $users = $this->userRepository->findAll();
        $event = $this->eventRepository->getById($id);

        $userSub = [];
        $i=0;

        foreach ($users as $user) {
            if ($this->subscriptionRepository->is_user_subscribed($user->id, $event->id)) {
             $userSub[$i] = $user;
            }
            $i++;
        }

        return view('events.subscribers', compact('userSub', 'event'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        if (!session()->has('user') || (session('role') != 4) || session('role') != 2) {
            return 'Vous devez être connecté et avoir le statut Admin pour accéder à cette page';
        }

        $eventCategories = $this->eventCatRepository->findAll();

        return view('events.creation', compact('eventCategories'));
    }

    /**
     * Search specific event with name
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function search(Request $request)
    {
        $eventCategories = $this->eventCatRepository->findAll();
        $search = $request->input('search');

        $query = Event::where('name', 'LIKE', '%' . $search . '%');
        $i = 0;

        $categories = $request->input('categories');

        if(isset($categories))
            if(is_array($categories))
                foreach($categories as $category)
                {
                    if($i == 0)
                        $query->whereHas('eventCategories', function($query) use ($category)
                        {
                           $query->where('id', '=', $category);
                        });
                    else
                        $query->orWhereHas('eventCategories', function($query) use ($category)
                        {
                            $query->where('id', '=', $category);
                        });
                    $i++;
                }

        $sort           = $request->input('sort');
        $sort_direction = $request->input('sort-direction');
        if(isset($sort) && isset($sort_direction))
            $query->orderBy($request->input('sort'), $request->input('sort-direction'));

        $priceMinimum = $request->input('price-min');
        $priceMaximum = $request->input('price-max');

        if(isset($priceMinimum))
            $query->where('price', '>=', $priceMinimum);
        if(isset($priceMaximum))
            $query->where('price', '<=', $priceMaximum);

        $states = array(
            'scheduled' => $request->input('scheduled'),
            'past'      => $request->input('past'),
            'proposed'  => $request->input(('proposed'))
        );

        $j = 0;

        foreach($states as $key => $state)
        {
            if(isset($state))
            {
                if($j == 0)
                    if($key == 'scheduled')
                        $query->where('scheduled', '=', 1)->where('begin_at', '>=', Carbon::now());
                    if($key == 'past')
                        $query->where('scheduled', '=', 1)->where('begin_at', '<', Carbon::now());
                    if($key == 'proposed')
                        $query->where('scheduled', '=', 0);
                else
                    if($key == 'scheduled')
                        $query->orWhere('scheduled', '=', 1)->where('end_at', '>=', Carbon::now());
                    if($key == 'past')
                        $query->orWhere('scheduled', '=', 1)->where('end_at', '<', Carbon::now());
                    if($key == 'proposed')
                        $query->orWhere('scheduled', '=', 0);

                $j++;
            }
        }

        $events = $query->paginate(self::NB_PER_PAGE);
        $links = $events->render();

        $params = compact('events', 'links', 'eventCategories');

        return $request->ajax() ? response()->json($params) : view('events.index', $params);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventCreateRequest $request) {
        if (!session()->has('user') || (session('role') != 4) || session('role') != 2) {
            return 'Vous devez être connecté et avoir le statut Admin pour accéder à cette page';
        }

        $event = $this->eventRepository->store(array_merge($request->all(), array('user_id' => session('user'))));

        $this->eventCatRepository->storeRelation($event, $request->input('categories'));

        $image = $request->file('picture');
        $extension = $image->getClientOriginalExtension();
        $picture_name = $request->input('picture_name') . '-' . $event->id;

        $picture_slug = SlugGestion::slugify(($picture_name));

        FileUploadGestion::uploadFile($image, $picture_slug, 'event-photos');

        $this->pictureRepository->store(array('name' => $picture_name, 'event_id' => $event->id, 'extension' => $extension));

        return redirect('events')->withOk("L'évènement ". $event->name . " a été proposé à l'équipe du BDE.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id) {

        $event = $this->eventRepository->getById($id);
        $eventPhotos = $this->eventPhotoRepository->findByEventId($id);
        $comments = $this->commentRepository->findByEventId($id);

        $event_photos_users = array();
        foreach($eventPhotos as $photo)
            $event_photos_users[$photo->id] = $this->userRepository->find(array('id' => $photo->user_id));

        $actualUser = session('user');
        $userRole = session('role');


        $subscriptions = $this->subscriptionRepository->get_subscriptions($id);
        $is_user_subscribed = $this->subscriptionRepository->is_user_subscribed(session('user'), $id);

        return view('events.show', compact('event','comments', 'subscriptions', 'is_user_subscribed', 'eventPhotos', 'event_photos_users','userRole'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id) {
        if (!session()->has('user') || (session('role') != 4) || session('role') != 2) {
            return 'Vous devez être connecté et avoir le statut Admin pour accéder à cette page';
        }

        $event = $this->eventRepository->getById($id);
        $eventCategories = $this->eventCatRepository->findAll();

        return view('events.edit', compact('event','eventCategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EventUpdateRequest $request, $id) {
        if (!session()->has('user') || (session('role') != 4) || session('role') != 2) {
            return 'Vous devez être connecté et avoir le statut Admin pour accéder à cette page';
        }

        $picture        = new Picture();
        $eventCatRepo   = new EventCatRepository();

        $event = $this->eventRepository->update($id, $request->all());
        $eventCatRepo->updateRelation($event, $request->input('categories'));

        $image = $request->file('picture');
        if(isset($image))
        {
            $extension = $image->getClientOriginalExtension();
            $picture_name = $request->input('picture_name') . '-' . $event->id;

            $picture_slug = SlugGestion::slugify(($picture_name));

            FileUploadGestion::uploadFile($image, $picture_slug, 'event-photos');

            if(isset($picture_name))
                $this->pictureRepository->update($id, array('name' => $picture_name));
        }

        return redirect('events/' . $id)->withOk("L'évènement".$request->input('name')."a été modifié.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id) {
        if (!session()->has('user') || (session('role') != 4) || session('role') != 2) {
            return 'Vous devez être connecté et avoir le statut Admin pour accéder à cette page';
        }

        $this->eventRepository->destroy($id);

        return redirect()->back();
    }

    /**
     * Creates a like on an event
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function likeEvent($id_event, Request $request) {
        $id_user = session('user');
        $code = '';
        if (!isset($id_user)) {
            $code = '401';
        } else {
            if (!self::hasLiked($id_event, $id_user)) {
                $like = new Like;
                $like -> id_event = $id_event;
                $like -> id_user = $id_user;
                $like -> save();
                $code = '200';
            } else {
                $code = '403';
            }
        }
        return response()->json($code);
    }

    /**
     * Return the number of likes for an event
     *
     * @param $id_event
     * @return int
     */
    public function countLikes($id_event) {
        $likes = Like::where('id_event', $id_event)->get();
        return count($likes);
    }

    /**
     * Say if an user has liked a specific event
     *
     * @param $id_event
     * @param $id_user
     * @return bool
     */
    public function hasLiked($id_event, $id_user) {
        $likes = Like::whereRaw('id_event=' . $id_event . ' and id_user=' . $id_user)->get();
        return count($likes) > 0;
    }

    /**
     * Send mail to BDE and hide reported comment
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function report(Request $request) {
        if (!session()->has('user') || session('role') != 3) {
            return 'Vous devez être connecté et avoir le statut Cesi Staff pour signaler un commentaire';
        }

        //do the fucking change of hide attribute
        $id = $request->input('comment_id');
        $comment = $this->commentRepository->getById($id);

        $comment->hidden = true;
        $comment->save();

        $users = $this->userRepository->findAll();

        foreach ($users as $user) {
            if ($user->role->_id == 4 || $user->role->_id == 2) {
                Mail::to($user)->send(new reportMail);
            }
        }
        return redirect()->back();
    }

}
