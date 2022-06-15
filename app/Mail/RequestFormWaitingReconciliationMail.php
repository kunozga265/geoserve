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
    public $emailSubject;
    public $title;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($accountant,$title)
    {
        $this->userName=$accountant->firstName." ".$accountant->lastName;
        $this->title=$title;
        $this->emailSubject=$title. " Waiting Reconciliation";
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.request-form-waiting-reconciliation')->subject($this->emailSubject);
    }
}
