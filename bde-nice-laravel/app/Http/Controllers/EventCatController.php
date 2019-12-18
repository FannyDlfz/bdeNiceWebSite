<?php

namespace App\Http\Controllers;

use App\Repositories\EventCatRepository;
use App\Http\Requests\EventCatCreateRequest;
use App\Http\Requests\EventCatUpdateRequest;

class EventCatController extends Controller {

    protected $eventCatRepository;

    public function __construct(EventCatRepository $eventCatRepository) {
        $this->eventCatRepository = $eventCatRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        return view('articleCatIndex');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create() {
        return view('eventCategories.creation');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(EventCatCreateRequest $request) {

        $eventCat = $this->eventCatRepository->store($request->all());

        return redirect('/events/');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id) {

        $eventCategory = $this->eventCatRepository->getById($id);

        return view('eventCategories.edit', compact('eventCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(EventCatUpdateRequest $request, $id) {
        $this->eventCatRepository->update($id, $request->all());

        return redirect('/events/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id) {
        $this->eventCatRepository->destroy($id);
        return redirect('/events/');
    }
}
