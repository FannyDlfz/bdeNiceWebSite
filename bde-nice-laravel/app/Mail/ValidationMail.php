<?php

namespace App\Mail;

use App\Command;
use App\Repositories\APIModelRepository;
use App\Repositories\ArticleRepository;
use App\Repositories\CommandRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class validationMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $userRepository;
    protected $articleRepository;
    protected $commandRepository;
    protected $commands;

    /**
     * Create a new message instance.
     *
     * @param ArticleRepository $articleRepository
     */
    public function __construct()
    {
        $this->articleRepository = new articleRepository;
        $this->commandRepository = new commandRepository;
        $this->userRepository    = new APIModelRepository('App\User', '/api/users');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        /*$user = session('user');
        var_dump($user);
        die;
        $username = get_current_user()->name;
        $user_id = get_current_user()->id;

        $articles = $this->articleRepository->findAll();
        $commands = $this->commandRepository->findAll();
        $commandUserId = $this->commandRepository->getByUserId($user_id);



        foreach ($commands as $command)
        {
            if ($command->user_id == $user_id)
            {
                $getArticles = $command->article_id;

                foreach ($articles as $article)
                {
                    foreach ($getArticles as $getArticle)
                    {
                        if($getArticles == $articles->id)
                        {
                            $AOrderName = $article->name;
                        }
                    }
                }
            }
        }
*/


        return $this->view('mails.validationMail'/*, compact('AOrderName', 'username')*/);
    }
}
