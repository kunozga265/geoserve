<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestFormInitiatedMail extends Mailable implements ShouldQueue, ShouldBeUnique
{
    use Queueable, SerializesModels;

    public $userName;
    public $_subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name,$subject)
    {
        $this->userName=$name;
        $this->_subject=$subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.request-form-initiated')->subject($this->_subject);
    }
}
