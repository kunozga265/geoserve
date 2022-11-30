<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
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
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        //get user
        $user=(new AppController())->getAuthUser($request);

        $unsorted=$user->userNotifications()->latest()->get();
        $sorted=[];

        if ($unsorted->isEmpty()!==0){
            $currentMonth=date('F',$unsorted[0]->created_at->getTimestamp());
            $currentYear=date('Y',$unsorted[0]->created_at->getTimestamp());

            $item=0;
            $index=0;
            foreach ($unsorted as $notification){
                //Mark as read
                if($notification->read==0)
                    $notification->update(['read'=>1]);

                if ($item==0){
                    $sorted[0]=[
                        'month'         => $currentMonth,
                        'year'          => $currentYear,
                        'notifications' => [new NotificationResource($notification)]
                    ];
                }else{
                    $month=date('F',$unsorted[$item]->created_at->getTimestamp());
                    $year=date('Y',$unsorted[$item]->created_at->getTimestamp());

                    if ($currentMonth===$month && $currentYear===$year){
                        $sorted[$index]['notifications'][]=new NotificationResource($notification);
                    }else{
                        $index+=1;
                        $currentMonth=date('F',$unsorted[$item]->created_at->getTimestamp());
                        $currentYear=date('Y',$unsorted[$item]->created_at->getTimestamp());

                        $sorted[$index]=[
                            'month'         => $currentMonth,
                            'year'          => $currentYear,
                            'notifications' => [new NotificationResource($notification)]
                        ];
                    }
                }
                $item+=1;
            }
        }

        if ((new AppController())->isApi($request))
            //API Response
            return response()->json($sorted);
        else{
            //Web Response
            return Inertia::render('Notifications',[
                'notificationContainer' =>$sorted
            ]);
        }
    }


    public function notifyManagement($object, $type)
    {
        $role=Role::where('name','management')->first();
        $managers=$role->users;

        if ($type == "USER_NEW"){
            //object is user
            $message="$object->firstName $object->lastName has registered into the system. Ensure you confirm their details and verify their account to be able to use the system.";
            $subject="New User: $object->firstName $object->lastName";

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

                //Send a push notification to the app for the manager
                $this->pushNotification($manager->position->title,$subject,$message);
            }

            //Send email to managers
            Mail::to($managers)->send(new UserNewMail($subject));

        }elseif ($type == "PROJECT_NEW"){
            //project is the object
            $message="A new project ($object->name) has been registered into the system. Please confirm its details and verify it.";
            $subject="New Project: ".$object->name;
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

                //Send a push notification to the app for the manager
                $this->pushNotification($manager->position->title,$subject,$message);
            }

            //Send email to managers
            Mail::to($managers)->send(new ProjectNewMail($object));

        }elseif ($type == "VEHICLE_NEW"){
            $message="A new vehicle with registration number: $object->vehicleRegistrationNumber has been registered into the system. Please confirm its details and verify it.";
            $subject="New Vehicle: ".$object->vehicleRegistrationNumber;
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

                //Send a push notification to the app for the manager
                $this->pushNotification($manager->position->title,$subject,$message);
            }

            //Send email to managers
            Mail::to($managers)->send(new VehicleNewMail($object));

        }elseif ($type == "REQUEST_FORM_PENDING"){
            //object is the request
            $name= $object->user->firstName. " " .$object->user->lastName;
            $positionTitle = $object->user->position->title;
            $message="$name ($positionTitle) has submitted a request. May you please attend to it as soon as possible.";
            $subject=$this->getRequestTitle($object->type,$object->code)." Pending Approval";

            //Create a notification for managers
            foreach ($managers as $manager){
                Notification::create([
                    'contents'  =>  json_encode([
                        'message'   => $message,
                        'type'      => $object->type,
                        'requestId' => $object->id
                    ]),
                    'type'      =>  $type,
                    'user_id'   =>  $manager->id,
                ]);

                //Send a push notification to the app for the manager
                $this->pushNotification($manager->position->title,$subject,$message);

                //Send email to manager
                Mail::to($manager)->send(new RequestFormPendingApprovalMail($manager,$message,$subject));
            }
        }elseif ($type == "REQUEST_FORM_RESUBMITTED"){
            $name= $object->user->firstName. " " .$object->user->lastName;
            $positionTitle = $object->user->position->title;
            $message="$name ($positionTitle) has edited and resubmitted their request. May you please attend to it as soon as possible.";
            $subject=$this->getRequestTitle($object->type,$object->code)." Pending Approval - Resubmitted";

            //Create a notification for managers
            foreach ($managers as $manager){
                Notification::create([
                    'contents'  =>  json_encode([
                        'message'   => $message,
                        'type'      => $object->type,
                        'requestId' => $object->id
                    ]),
                    'type'      =>  $type,
                    'user_id'   =>  $manager->id,
                ]);

                //Send a push notification to the app for the manager
                $this->pushNotification($manager->position->title,$subject,$message);

                //Send email to manager
                Mail::to($manager)->send(new RequestFormPendingApprovalMail($manager,$message,$subject));
            }
        }
    }

    public function notifyUser($object, $type)
    {
        if($type=="USER_VERIFIED"){
            //object is user
            $message="Your account has been verified. You are now able to use the system.";
            Notification::create([
                'contents'  =>  json_encode([
                    'message' => $message
                ]),
                'type'      => $type,
                'user_id'   =>  $object->id,
            ]);

            //Send a push notification to the app for the user
            $name=$object->firstName.$object->lastName;
            $this->pushNotification($name,"Account Verified",$message);

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

            //Send a push notification to the app for the user
            $name=$object->firstName.$object->lastName;
            $this->pushNotification($name,"Account Disabled",$message);

            Mail::to($object)->send(new UserDisabledMail());

        }elseif($type=="REQUEST_FORM_PENDING"){
            //Find the next person(s) to approve
            $position=Position::find($object->stagesApprovalPosition);
            $employees=$position->users;

            $name= $object->user->firstName. " " .$object->user->lastName;
            $positionTitle = $object->user->position->title;
            $message="$name ($positionTitle) has submitted a request. May you please attend to it as soon as possible.";
            $subject=$this->getRequestTitle($object->type,$object->code)." Pending Approval";

            foreach ($employees as $employee) {

                Notification::create([
                    'contents' => json_encode([
                        'message'   => $message,
                        'type'      => $object->type,
                        'requestId' => $object->id,
                    ]),
                    'type' => $type,
                    'user_id' => $employee->id,
                ]);

                //Send a push notification to the app for the user
                $this->pushNotification($employee->position->title,$subject,$message);

                //Send email to employees who can approve
                Mail::to($employee)->send(new RequestFormPendingApprovalMail($employee, $message,$subject));
            }
        }elseif($type=="REQUEST_FORM_RESUBMITTED"){
            //Find the next person(s) to approve
            $position=Position::find($object->stagesApprovalPosition);
            $employees=$position->users;

            $name= $object->user->firstName. " " .$object->user->lastName;
            $positionTitle = $object->user->position->title;
            $message="$name ($positionTitle) has edited and resubmitted their request. May you please attend to it as soon as possible.";
            $subject=$this->getRequestTitle($object->type,$object->code)." Pending Approval - Resubmitted";

            foreach ($employees as $employee) {

                Notification::create([
                    'contents' => json_encode([
                        'message'   => $message,
                        'type'      => $object->type,
                        'requestId' => $object->id,
                    ]),
                    'type' => $type,
                    'user_id' => $employee->id,
                ]);

                //Send a push notification to the app for the user
                $this->pushNotification($employee->position->title,$subject,$message);

                //Send email to managers
                Mail::to($employee)->send(new RequestFormPendingApprovalMail($employee, $message,$subject));
            }
        }elseif($type=="INITIATED"){
            $message="The request has been initiated by the Accounts Department.";
            $subject= $this->getRequestTitle($object->type,$object->code). " Initiated";

            Notification::create([
                'contents'  =>  json_encode([
                    'message'   => $message,
                    'type'      => $object->type,
                    'requestId' => $object->id,
                ]),
                'type'      => $type,
                'user_id'   =>  $object->id,
            ]);

            //Send a push notification to the app for the user
            $name=$object->firstName." ".$object->lastName;
            $this->pushNotification($name,$subject,$message);

            Mail::to($object->user)->send(new RequestFormInitiatedMail($name,$subject));

        }elseif($type=="RECONCILED") {
            $message = "The request has been reconciled by the Accounts Department.";
            $subject= $this->getRequestTitle($object->type,$object->code). " Reconciled";

            Notification::create([
                'contents' => json_encode([
                    'message' => $message,
                    'type' => $object->type,
                    'requestId' => $object->id,
                ]),
                'type' => $type,
                'user_id' => $object->id,
            ]);

            //Send a push notification to the app for the user
            $name=$object->firstName." ".$object->lastName;
            $this->pushNotification($name,$subject,$message);

            Mail::to($object->user)->send(new RequestFormReconciledMail($name,$subject));

        }
    }

    public function notifyApproval($requestForm, $approvedBy)
    {
        $approvedByName= $approvedBy->firstName. " " .$approvedBy->lastName;
        $positionTitle = $approvedBy->position->title;
        $message="$approvedByName ($positionTitle) has approved your request. Your request has gone to the next stage.";
        $subject= $this->getRequestTitle($requestForm->type,$requestForm->code). " Approved";
        Notification::create([
            'contents' => json_encode([
                'message'   => $message,
                'type'      => $requestForm->type,
                'requestId' => $requestForm->id,
            ]),
            'type' => "REQUEST_FORM_APPROVED",
            'user_id' => $requestForm->user->id,
        ]);

        //Send a push notification to the app for the user
        $name=$requestForm->firstName." ".$requestForm->lastName;
        $this->pushNotification($name,$subject,$message);

        //Send email
        Mail::to($requestForm->user)->send(new RequestFormApprovedMail($requestForm,$approvedBy,$subject));
    }

    public function notifyDenial($requestForm, $deniedBy)
    {
        $deniedByName= $deniedBy->firstName. " " .$deniedBy->lastName;
        $positionTitle = $deniedBy->position->title;
        $message="The request has been denied by $deniedByName ($positionTitle). View the request to see the reason why.";
        $subject= $this->getRequestTitle($requestForm->type,$requestForm->code). " Denied";

        Notification::create([
            'contents' => json_encode([
                'message'   => $message,
                'type'      => $requestForm->type,
                'requestId' => $requestForm->id,
            ]),
            'type' => "REQUEST_FORM_DENIED",
            'user_id' => $requestForm->user->id,
        ]);

        //Send a push notification to the app for the user
        $name=$requestForm->firstName." ".$requestForm->lastName;
        $this->pushNotification($name,$subject,$message);

        //Send email
        Mail::to($requestForm->user)->send(new RequestFormDeniedMail($requestForm->user,$message,$subject));
    }

    public function notifyFinance($requestForm,$type)
    {
        $role=Role::where('name','accountant')->first();
        $accountants=$role->users;

        if($type=="WAITING_INITIATE"){
            $name= $requestForm->user->firstName. " " .$requestForm->user->lastName;
            $positionTitle = $requestForm->user->position->title;
            $message="$name ($positionTitle) has submitted a request and it has been approved. May you please attend to it as soon as possible.";
            $subject= $this->getRequestTitle($requestForm->type,$requestForm->code). " Waiting Initiation";

            foreach ($accountants as $accountant){

                Notification::create([
                    'contents' => json_encode([
                        'message'   => $message,
                        'type'      => $requestForm->type,
                        'requestId' => $requestForm->id,
                    ]),
                    'type'    => $type,
                    'user_id' => $accountant->id,
                ]);

                //Send a push notification to the app for the accountant
                $this->pushNotification($accountant->position->title,$subject,$message);

                //Send email to accountants
                Mail::to($accountant)->send(new RequestFormWaitingInitiationMail($accountant,$message,$subject));

            }
        }elseif($type=="WAITING_RECONCILE"){
            $title= $this->getRequestTitle($requestForm->type,$requestForm->code);
            $message="$title has been initiated. Please ensure all required information has been submitted to reconcile this request.";
            $subject= $title. " Waiting Reconciliation";

            foreach ($accountants as $accountant){

                Notification::create([
                    'contents' => json_encode([
                        'message'   => $message,
                        'type'      => $requestForm->type,
                        'requestId' => $requestForm->id,
                    ]),
                    'type'    => $type,
                    'user_id' => $accountant->id,
                ]);

                //Send a push notification to the app for the accountant
                $this->pushNotification($accountant->position->title,$subject,$message);

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

    public function getRequestTitle($type,$code){
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

    private function pushNotification($title,$subject,$message){
        //notification
        try{
            $client=new Client();
            $to=str_replace(' ','',$title);
            $notificationRequest=$client->request('POST','https://fcm.googleapis.com/fcm/send',[
                'headers'=>[
                    'Authorization' => 'key=AAAAFXyrcvQ:APA91bGV3qVuwe94RAhjmH2HcNuGTUqkAqtd9dtoopn1h6Qp55T8m9Plnb9iGbPbZZ7h1uM0i2ryQhEtgk6Tj3XMY7qC1qPEIFFl_zxS798I6_O8HfAfRrJHCitTYdhgRSraN5ZI9Fh9',
                    'Content-Type'   =>  'application/json',
                ],
                'json'=>[
                    "priority"=>"high",
                    "content_available"=>true,
                    "to"=>"/topics/$to",
                    "notification"=>[
                        "title"=>$subject,
                        "body"=>$message
                    ]
                ]
            ]);

            // Develop a use for this
             if ($notificationRequest->getStatusCode()==200){}


        }catch (\GuzzleHttp\Exception\GuzzleException $e){
            //Log information
        }
    }
}
