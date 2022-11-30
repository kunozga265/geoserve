<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestFormDeniedMail extends Mailable implements ShouldQueue, ShouldBeUnique
{
    use Queueable, SerializesModels;

    public $userName;
    public $_message;
    public $_subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$_message,$_subject)
    {
        $this->userName=$user->firstName." ".$user->lastName;
        $this->_message=$_message;
        $this->_subject=$_subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.request-form-denied')->subject($this->_subject);
    }
}
