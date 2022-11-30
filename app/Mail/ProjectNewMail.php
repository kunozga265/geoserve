<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProjectNewMail extends Mailable implements ShouldQueue, ShouldBeUnique
{
    use Queueable, SerializesModels;
    public $_subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($_subject)
    {
        $this->_subject=$_subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.project-new')->subject($this->_subject);
    }
}
