<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestFormApprovedMail extends Mailable implements ShouldQueue, ShouldBeUnique
{
    use Queueable, SerializesModels;
    public $approvedBy;
    public $userName;
    public $positionTitle;
    public $_subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($requestForm, $approvedBy,$subject)
    {
        $this->approvedBy=$approvedBy->firstName." ".$approvedBy->lastName;
        $this->userName=$requestForm->user->firstName." ".$requestForm->user->lastName;
        $this->positionTitle=$approvedBy->position->title;
        $this->_subject=$subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.request-form-approved')->subject($this->_subject);
    }
}
