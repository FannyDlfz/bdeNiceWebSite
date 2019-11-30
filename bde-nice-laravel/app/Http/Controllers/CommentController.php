<?php

namespace App\Http\Controllers;

use App\Repositories\CommentRepository;

use App\Http\Requests\CommentCreateRequest;
use App\Http\Requests\CommentUpdateRequest;

class CommentController extends Controller {

    protected $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //not necessary?
    public function index() {

        $comments = $this->commentRepository;

        return view('CommentIndex', compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentCreateRequest $request)
    {
        $params = $request->all();
        $params['user_id'] = session('user');

        $this->commentRepository->store($params);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {

        $comment = $this->commentRepository->getById($id);

        return view('show', compact('comment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {

        $comment = $this->commentRepository->getById($id);

        return view('edit', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CommentUpdateRequest $request, $id) {

        $this->commentRepository->update($id, $request->all());

        return redirect('comment')->withOk("Votre commentaire".$request->input('id')."a été modifié.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

        $this->commentRepository->destroy($id);

        return redirect()->back();
    }
}
