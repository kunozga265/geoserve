<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestFormWaitingInitiationMail extends Mailable implements ShouldQueue, ShouldBeUnique
{
    use Queueable, SerializesModels;
    public $requestedBy;
    public $userName;
    public $positionTitle;
    public $emailSubject;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($requestForm, $accountant)
    {
        $this->userName=$accountant->firstName." ".$accountant->lastName;
        $this->requestedBy=$requestForm->user->firstName." ".$requestForm->user->lastName;
        $this->positionTitle=$requestForm->user->position->title;

        switch ($requestForm->type) {
            case "CASH":
                $this->emailSubject = "Cash Request [$requestForm->code] Waiting Initiation";
                break;
            case "MATERIALS":
                $this->emailSubject = "Materials Request [$requestForm->code] Waiting Initiation";
                break;
            case "VEHICLE_MAINTENANCE":
                $this->emailSubject = "Vehicle Maintenance Request [$requestForm->code] Waiting Initiation";
                break;
            default:
                $this->emailSubject = "Fuel Request [$requestForm->code] Waiting Initiation";
                break;
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.request-form-waiting-initiation')->subject($this->emailSubject);
    }
}
