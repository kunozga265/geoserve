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
    public $deniedBy;
    public $emailSubject;
    public $positionTitle;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$deniedBy,$title)
    {
        $this->userName=$user->firstName." ".$user->lastName;
        $this->deniedBy=$deniedBy->firstName." ".$deniedBy->lastName;
        $this->emailSubject=$title. " Denied";
        $this->positionTitle=$deniedBy->position->title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.request-form-denied')->subject($this->emailSubject);
    }
}
