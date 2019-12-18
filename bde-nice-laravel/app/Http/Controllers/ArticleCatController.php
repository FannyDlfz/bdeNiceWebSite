<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleCatUpdateRequest;
use App\Repositories\ArticleCatRepository;
use App\Http\Requests\ArticleCatCreateRequest;

class ArticleCatController extends Controller {

    private $articleCatRepository;

    public function __construct(ArticleCatRepository $articleCatRepo) {
        $this->articleCatRepository = $articleCatRepo;
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
        if (!session()->has('user') || (session('role') != 4) || session('role') != 2) {
            return 'Vous devez être connecté et avoir le statut Admin pour accéder à cette page';
        }

        return view('articleCategories.creation');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(ArticleCatCreateRequest $request) {
        if (!session()->has('user') || (session('role') != 4) || session('role') != 2) {
            return 'Vous devez être connecté et avoir le statut Admin pour accéder à cette page';
        }

        $category = $this->articleCatRepository->store($request->all());

        return redirect('/articles/');

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

        $articleCategory = $this->articleCatRepository->getById($id);

        return view('articleCategories.edit', compact('articleCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(ArticleCatUpdateRequest $request, $id) {
        if (!session()->has('user') || (session('role') != 4) || session('role') != 2) {
            return 'Vous devez être connecté et avoir le statut Admin pour accéder à cette page';
        }
        $this->articleCatRepository->update($id, $request->all());

        return redirect('/articles/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id) {
        if (!session()->has('user') || (session('role') != 4) || session('role') != 2) {
            return 'Vous devez être connecté et avoir le statut Admin pour accéder à cette page';
        }

        $this->articleCatRepository->destroy($id);
        return redirect('articleCat');
    }
}
