<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestFormWaitingReconciliationMail extends Mailable implements ShouldQueue, ShouldBeUnique
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
    public function __construct($accountant,$message,$subject)
    {
        $this->userName=$accountant->firstName." ".$accountant->lastName;
        $this->_subject=$subject;
        $this->_message=$message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.request-form-waiting-reconciliation')->subject($this->_subject);
    }
}
