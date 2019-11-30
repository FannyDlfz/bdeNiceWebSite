<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleCatUpdateRequest;
use App\Repositories\ArticleCatRepository;
use App\Http\Requests\ArticleCatCreateRequest;
use Illuminate\Http\Request;

class ArticleCatController extends Controller {

    private $articleCatRepository;

    public function __construct(ArticleCatRepository $articleCatRepo) {
        $this->articleCatRepository = $articleCatRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('articleCatIndex');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('articleCategories.creation');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleCatCreateRequest $request) {

        $category = $this->articleCatRepository->store($request->all());

        return redirect('/articles/');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $articleCategory = $this->articleCatRepository->getById($id);

        return view('articleCategories.edit', compact('articleCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleCatUpdateRequest $request, $id) {

        $this->articleCatRepository->update($id, $request->all());

        return redirect('/articles/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

        $this->articleCatRepository->destroy($id);
        return redirect('articleCat');
    }
}
