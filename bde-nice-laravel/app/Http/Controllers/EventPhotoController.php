<?php

namespace App\Http\Controllers;

use App\EventPhoto;
use App\Gestion\FileUploadGestion;
use App\Gestion\SlugGestion;
use App\Repositories\CommentRepository;
use App\User;

use App\Repositories\APIModelRepository;
use App\Repositories\EventPhotoRepository;

use App\Http\Requests\EventPhotoCreateRequest;
use App\Http\Requests\EventPhotoUpdateRequest;

class EventPhotoController extends Controller {

    protected $eventPhotoRepository;
    protected $userRepository;
    protected $commentRepository;

    public function __construct(EventPhotoRepository $eventPhotoRepository) {
        $this->eventPhotoRepository = $eventPhotoRepository;
        $this->userRepository = new APIModelRepository('App\User', '/api/users');
        $this->commentRepository = new CommentRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('eventPhotoIndex');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        return view('eventPhotos.create', array('event_id' => $id));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventPhotoCreateRequest $request)
    {
        $description = $request->input('description');
        $event_id = $request->input('event_id');
        $name = $request->input('name');

        $image = $request->file('picture');
        if(empty($image))
            return redirect('events-photos/create/' . $event_id);

        $extension = $image->getClientOriginalExtension();
        $picture_name = $name . '-' . $event_id;

        $picture_slug = SlugGestion::slugify(($picture_name));
        FileUploadGestion::uploadFile($image, $picture_slug, 'event-photos-users');

        $eventPhoto = $this->eventPhotoRepository->store(array
        (
            'name'          => $picture_name,
            'description'   => $description,
            'event_id'      => $event_id,
            'user_id'       => session('user'),
            'extension'     => $extension
        ));

        return redirect('/events/' . $request->input('event_id'))->withOk("La photo". $eventPhoto->name . "a été sauvegardée");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //to review
    public function show($id) {

        $eventPhoto = $this->eventPhotoRepository->getById($id);
        $user = new User();
        $user = $this->userRepository->find(array('id' => $eventPhoto->user_id));
        $comments = $this->commentRepository->findByEventPhotoId($id);

        return view('eventPhotos.show', compact('eventPhoto', 'user','comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //to review
    public function edit($id) {
        $eventPhoto = $this->eventPhotoRepository->getById($id);

        return view('edit', compact('eventPhoto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EventPhotoUpdateRequest $request, $id) {

        $this->eventPhotoRepository->update($id, $request->all());

        return redirect('eventPhotoShow')->withOk("La photo".$request->input('name')."a été modifié.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

        $this->eventPhotoRepository->destroy($id);

        return redirect()->back();
    }

    public function downloadImage()
    {
        return response()->download('/event-photos-users');
    }

}
