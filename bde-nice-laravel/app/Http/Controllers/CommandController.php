<?php

namespace App\Http\Controllers;

use App\Repositories\CommandRepository;

class CommandController extends Controller {

    protected $commandRepository;

    public function __construct(CommandRepository $commandRepository) {

        $this->commandRepository = $commandRepository;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {

        $commands = $this->commandRepository;

        return view('CommandIndex', compact('commands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create() {
        return view('createCommand');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id) {

        $commands = $this->commandRepository->getById($id);

        return view('show', compact('commands'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id) {

        $this->commandRepository->destroy($id);

        return redirect()->back();
    }
}
