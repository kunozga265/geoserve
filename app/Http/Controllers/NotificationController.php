<?php

namespace App\Http\Controllers;

use App\Mail\ProjectNewMail;
use App\Mail\RequestFormApprovedMail;
use App\Mail\RequestFormDeniedMail;
use App\Mail\RequestFormInitiatedMail;
use App\Mail\RequestFormPendingApprovalMail;
use App\Mail\RequestFormReconciledMail;
use App\Mail\RequestFormWaitingInitiationMail;
use App\Mail\RequestFormWaitingReconciliationMail;
use App\Mail\UserDisabledMail;
use App\Mail\UserNewMail;
use App\Mail\UserVerifiedMail;
use App\Mail\VehicleNewMail;
use App\Models\Notification;
use App\Models\Position;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NotificationController extends Controller
{
    public function notifyManagement($object, $type)
    {
        $role=Role::where('name','management')->first();
        $managers=$role->users;

        if ($type == "USER_NEW"){
            $message="$object->firstName $object->lastName has registered into the system. Ensure you confirm their details and verify their account to be able to use the system.";
            //Create a notification for managers
            foreach ($managers as $manager){
                Notification::create([
                    'contents'  =>  json_encode([
                        'message'   => $message,
                        'userId'    => $object->id
                    ]),
                    'type'      =>  $type,
                    'user_id'   =>  $manager->id,
                ]);
            }

            //Send email to managers
            Mail::to($managers)->send(new UserNewMail($object));

        }elseif ($type == "PROJECT_NEW"){
            $message="A new project ($$object->name) has been registered into the system. Please confirm its details and verify it.";
            //Create a notification for managers
            foreach ($managers as $manager){
                Notification::create([
                    'contents'  =>  json_encode([
                        'message'       => $message,
                        'projectId'     => $object->id
                    ]),
                    'type'      =>  $type,
                    'user_id'   =>  $manager->id,
                ]);
            }

            //Send email to managers
            Mail::to($managers)->send(new ProjectNewMail($object));

        }elseif ($type == "VEHICLE_NEW"){
            $message="A new vehicle with registration number: $object->vehicleRegistrationNumber has been registered into the system. Please confirm its details and verify it.";
            //Create a notification for managers
            foreach ($managers as $manager){
                Notification::create([
                    'contents'  =>  json_encode([
                        'message'   => $message,
                        'vehicleId' => $object->id
                    ]),
                    'type'      =>  $type,
                    'user_id'   =>  $manager->id,
                ]);
            }

            //Send email to managers
            Mail::to($managers)->send(new VehicleNewMail($object));

        }elseif ($type == "REQUEST_FORM_PENDING"){
            $name= $object->user->firstName. " " .$object->user->lastName;
            $positionTitle = $object->user->position->title;
            $message="$name ($positionTitle) has submitted a request. May you please attend to it as soon as possible.";

            //Create a notification for managers
            foreach ($managers as $manager){
                Notification::create([
                    'contents'  =>  json_encode([
                        'message'   => $message,
                        'type'      => $object->type,
                        'userId'    => $object->user->id
                    ]),
                    'type'      =>  $type,
                    'user_id'   =>  $manager->id,
                ]);

                //Send email to manager
                Mail::to($manager)->send(new RequestFormPendingApprovalMail($manager,$object));
            }
        }
    }

    public function notifyUser($object, $type)
    {
        if($type=="USER_VERIFIED"){
            $message="Your account has been verified. You are now able to use the system.";
            Notification::create([
                'contents'  =>  json_encode([
                    'message' => $message
                ]),
                'type'      => $type,
                'user_id'   =>  $object->id,
            ]);

            Mail::to($object)->send(new UserVerifiedMail());

        }elseif($type=="USER_DISABLED"){
            $message="Your account has been disabled. You are no longer able to use the system. If you have any queries, see the system administrator.";
            Notification::create([
                'contents'  =>  json_encode([
                    'message' => $message
                ]),
                'type'      => $type,
                'user_id'   =>  $object->id,
            ]);

            Mail::to($object)->send(new UserDisabledMail());

        }elseif($type=="REQUEST_FORM_PENDING"){
            //Find the next person(s) to approve
            $position=Position::find($object->stagesApprovalPosition);
            $employees=$position->users;

            $name= $object->user->firstName. " " .$object->user->lastName;
            $positionTitle = $object->user->position->title;
            $message="$name ($positionTitle) has submitted a request. May you please attend to it as soon as possible.";

            foreach ($employees as $employee) {

                Notification::create([
                    'contents' => json_encode([
                        'message'   => $message,
                        'type'      => $object->type,
                        'userId'    => $object->user->id,
                    ]),
                    'type' => $type,
                    'user_id' => $employee->id,
                ]);

                //Send email to managers
                Mail::to($employee)->send(new RequestFormPendingApprovalMail($employee, $object));
            }
        }elseif($type=="INITIATED"){
            $message="The request has been initiated by the Accounts Department.";
            $title= $this->getRequestTitle($object->type,$object->code);

            Notification::create([
                'contents'  =>  json_encode([
                    'message'   => $message,
                    'type'      => $object->type,
                    'userId'    => $object->user->id,
                ]),
                'type'      => $type,
                'user_id'   =>  $object->id,
            ]);

            Mail::to($object->user)->send(new RequestFormInitiatedMail($object->user,$title));

        }elseif($type=="RECONCILED") {
            $message = "The request has been reconciled by the Accounts Department.";
            $title = $this->getRequestTitle($object->type, $object->code);

            Notification::create([
                'contents' => json_encode([
                    'message' => $message,
                    'type' => $object->type,
                    'userId' => $object->user->id,
                ]),
                'type' => $type,
                'user_id' => $object->id,
            ]);

            Mail::to($object->user)->send(new RequestFormReconciledMail($object->user, $title));

        }
    }

    public function notifyApproval($requestForm, $approvedBy)
    {
        $name= $approvedBy->firstName. " " .$approvedBy->lastName;
        $positionTitle = $approvedBy->position->title;
        $message="$name ($positionTitle) has approved your request. Your request has gone to the next stage.";
        Notification::create([
            'contents' => json_encode([
                'message'   => $message,
                'type'      => $requestForm->type,
                'userId'    => $approvedBy->id,
            ]),
            'type' => "REQUEST_FORM_APPROVED",
            'user_id' => $requestForm->user->id,
        ]);

        //Send email to managers
        Mail::to($requestForm->user)->send(new RequestFormApprovedMail($requestForm,$approvedBy));
    }

    public function notifyDenial($requestForm, $deniedBy)
    {
        $title = $this->getRequestTitle($requestForm->type, $requestForm->code);
        $name= $deniedBy->firstName. " " .$deniedBy->lastName;
        $positionTitle = $deniedBy->position->title;
        $message="The request has been denied by $name ($positionTitle). View the request to see the reason why.";

        Notification::create([
            'contents' => json_encode([
                'message'   => $message,
                'type'      => $requestForm->type,
                'userId'    => $deniedBy->id,
            ]),
            'type' => "REQUEST_FORM_APPROVED",
            'user_id' => $requestForm->user->id,
        ]);

        //Send email to managers
        Mail::to($requestForm->user)->send(new RequestFormDeniedMail($requestForm->user,$deniedBy,$title));
    }

    public function notifyFinance($requestForm,$type)
    {
        $role=Role::where('name','accountant')->first();
        $accountants=$role->users;

        if($type=="WAITING_INITIATE"){
            $name= $requestForm->user->firstName. " " .$requestForm->user->lastName;
            $positionTitle = $requestForm->user->position->title;
            $message="$name ($positionTitle) has submitted a request and it has been approved. May you please attend to it as soon as possible.";

            foreach ($accountants as $accountant){

                Notification::create([
                    'contents' => json_encode([
                        'message'   => $message,
                        'type'      => $requestForm->type,
                        'userId'    => $requestForm->user->id,
                    ]),
                    'type'    => $type,
                    'user_id' => $accountant->id,
                ]);

                //Send email to accountants
                Mail::to($accountant)->send(new RequestFormWaitingInitiationMail($requestForm,$accountant));

            }
        }elseif($type=="WAITING_RECONCILE"){
            $title= $this->getRequestTitle($requestForm->type,$requestForm->code);
            $message="$title has been initiated. Please ensure all required information has been submitted to reconcile this request.";

            foreach ($accountants as $accountant){

                Notification::create([
                    'contents' => json_encode([
                        'message'   => $message,
                        'type'      => $requestForm->type,
                        'userId'    => $requestForm->user->id,
                    ]),
                    'type'    => $type,
                    'user_id' => $accountant->id,
                ]);

                //Send email to accountants
                Mail::to($accountant)->send(new RequestFormWaitingReconciliationMail($accountant,$title));

            }
        }
    }

    public function requestFormNotifications($requestForm,$type)
    {
        //Check if the stages have been approved
        if($requestForm->stagesApprovalStatus){
            //Notify Management
            $this->notifyManagement($requestForm,$type);

        }else{
            //Notify a user
            $this->notifyUser($requestForm,$type);
        }
    }

    private function getRequestTitle($type,$code){
        switch ($type){
            case "CASH":
                return "Cash Request [$code]";
                break;
            case "MATERIALS":
                return "Materials Request [$code]";
                break;
            case "VEHICLE_MAINTENANCE":
                return "Vehicle Maintenance Request [$code]";
                break;
            default:
                return "Fuel Request [$code]";
                break;

        }
    }
}
