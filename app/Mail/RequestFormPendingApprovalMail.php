<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestFormPendingApprovalMail extends Mailable implements ShouldQueue, ShouldBeUnique
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
    public function __construct($user,$requestForm)
    {
        $this->userName=$user->firstName." ".$user->lastName;
        $this->requestedBy=$requestForm->user->firstName." ".$requestForm->user->lastName;
        $this->positionTitle=$requestForm->user->position->title;

        switch ($requestForm->type){
            case "CASH":
                $this->emailSubject="Cash Request [$requestForm->code] Pending Approval";
                break;
            case "MATERIALS":
                $this->emailSubject="Materials Request [$requestForm->code] Pending Approval";
                break;
            case "VEHICLE_MAINTENANCE":
                $this->emailSubject="Vehicle Maintenance Request [$requestForm->code] Pending Approval";
                break;
            default:
                $this->emailSubject="Fuel Request [$requestForm->code] Pending Approval";
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
        return $this->view('emails.request-form-pending-approval')->subject($this->emailSubject);
    }
}
