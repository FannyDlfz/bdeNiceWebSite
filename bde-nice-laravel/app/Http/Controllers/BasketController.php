<?php

namespace App\Http\Controllers;

use App\Mail\validationMail;
use App\Repositories\APIModelRepository;
use App\Repositories\ArticleRepository;
use App\Repositories\CommandRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $article_id = $request->input('article_id');

        $this->commandRepository->storeRelation($id, $article_id);

        return back();
    }

    public function removeArticle(Request $request, $id)
    {
        $article_id = $request->input('article_id');

        $this->commandRepository->destroyRelation($id, $article_id);

        return back();
    }

    public function submit ()
    {
        $utilisateurQuiCommande = auth()->user();
        $users = $this->userRepository->findAll();

        foreach ($users as $user) {
            if ($user->role->_id == 4) {
                Mail::to($user)->send(new validationMail);
            }
        }
        return 'commande validée';
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
