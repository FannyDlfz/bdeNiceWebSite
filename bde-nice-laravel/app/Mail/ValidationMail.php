<?php

namespace App\Mail;

use App\Repositories\APIModelRepository;
use App\Repositories\ArticleRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class validationMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $userRepository;
    protected $articleRepository;

    /**
     * Create a new message instance.
     *
     * @param ArticleRepository $articleRepository
     */
    public function __construct()
    {
        $this->articleRepository = new articleRepository;
        $this->userRepository    = new APIModelRepository('App\User', '/api/users');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->view('mails.validationMail');
    }
}
