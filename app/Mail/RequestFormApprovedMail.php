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
    public $emailSubject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($requestForm, $approvedBy)
    {
        $this->approvedBy=$approvedBy->firstName." ".$approvedBy->lastName;
        $this->userName=$requestForm->user->firstName." ".$requestForm->user->lastName;
        $this->positionTitle=$approvedBy->position->title;

        switch ($requestForm->type){
            case "CASH":
                $this->emailSubject="Cash Request [$requestForm->code] Approved";
                break;
            case "MATERIALS":
                $this->emailSubject="Materials Request [$requestForm->code] Approved";
                break;
            case "VEHICLE_MAINTENANCE":
                $this->emailSubject="Vehicle Maintenance Request [$requestForm->code] Approved";
                break;
            default:
                $this->emailSubject="Fuel Request [$requestForm->code] Approved";
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
        return $this->view('emails.request-form-approved')->subject($this->emailSubject);
    }
}
