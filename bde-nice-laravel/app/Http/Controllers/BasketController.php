<?php

namespace App\Http\Controllers;

use App\Repositories\APIModelRepository;
use App\Repositories\CommandRepository;
use Illuminate\Http\Request;

class BasketController extends Controller
{
    protected $commandRepository;
    protected $userRepository;

    public function __construct(CommandRepository $commandRepository)
    {
        $this->commandRepository = $commandRepository;
        $this->userRepository    = new APIModelRepository('App\User', '/api/users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $basket = $this->commandRepository->getByUserId($id);
        if($basket == null)
            $basket = $this->commandRepository->store(array('submit' => false, 'user_id' => $id));

        return view('basket.show', compact('basket'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $article_id = $request->input('article_id');

        $this->commandRepository->storeRelation($id, $article_id);

        return back();
    }

    /**
     * Remove article from the basket
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeArticle(Request $request, $id)
    {
        $article_id = $request->input('article_id');

        $this->commandRepository->destroyRelation($id, $article_id);

        return back();
    }

    /*public function submit(Request $request, $id)
    {
        $user = $this->userRepository->find(array('id' => $id));
        $bdeMembers = $this->userRepository->find(array('role_id' => 2));

        Mail::send('emails.reminder', ['user' => $user], function ($m) use ($user) {
            $m->from('hello@app.com', 'Your Application');

            $m->to($user->email, $user->name)->subject('Your Reminder!');
        });
    }*/
}
