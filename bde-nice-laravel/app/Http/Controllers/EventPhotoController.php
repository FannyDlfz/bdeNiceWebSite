<?php

namespace App\Http\Controllers;

use App\Gestion\FileUploadGestion;
use App\Gestion\SlugGestion;
use App\Repositories\CommentRepository;
use App\User;

use App\Repositories\APIModelRepository;
use App\Repositories\EventPhotoRepository;

use App\Http\Requests\EventPhotoCreateRequest;
use App\Http\Requests\EventPhotoUpdateRequest;
use ZipArchive;

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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        return view('eventPhotoIndex');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($id)
    {
        return view('eventPhotos.create', array('event_id' => $id));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id) {

        $eventPhoto = $this->eventPhotoRepository->getById($id);
        $user = $this->userRepository->find(array('id' => $eventPhoto->user_id));
        $comments = $this->commentRepository->findByEventPhotoId($id);

        return view('eventPhotos.show', compact('eventPhoto', 'user','comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id) {

        $this->eventPhotoRepository->destroy($id);

        return redirect()->back();
    }

    /**
     * Returns a zip file containing all users' images
     *
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadImage()
    {
        $path = public_path('/event-photos-users');
        $fileName = 'img.zip';

        $zip = new ZipArchive();

        $success = $zip->open($path . '/' . $fileName, ZipArchive::CREATE);

        if($success === TRUE) {
            $files = scandir($path);
            unset($files[0], $files[1]);

            foreach ($files as $file) {
                $zip->addFile($path . '/' . $file, $file);
            }

            $zip->close();

            return response()->download($path . '/' . $fileName)->deleteFileAfterSend();
        }
        return redirect()->back();
    }

}
