<?php

namespace App\Http\Controllers;

use App\Exports\RequestsExport;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\VehicleResource;
use App\Models\Project;
use App\Models\Report;
use App\Models\RequestForm;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index()
    {
        $projects = Project::orderBy('name', 'asc')->where('verified', 1)->get();
        $vehicles = Vehicle::orderBy('vehicleRegistrationNumber', 'asc')->where('verified', 1)->get();
        $users=User::orderBy('firstName','asc')->get();
        return Inertia::render('Reports',[
            'users'         =>  UserResource::collection($users),
            'projects'=> ProjectResource::collection($projects),
            'vehicles'=> VehicleResource::collection($vehicles),
        ]);
    }

    public function getCurrentReport()
    {
        $month=date('F');
        $year=date('Y');

        if(Report::where('year',$year)->where('month',$month)->exists())
            return Report::where('year',$year)->where('month',$month)->first();
        else
            return Report::create(['year'  =>  $year, 'month' =>  $month,]);
    }

    public function generate(Request $request)
    {
        /* $request->validate([
             'type'              =>  ['required'],
             'requestType'       =>  ['required'],
             'requestStatus'     =>  ['required'],
             'startDate'         =>  ['required'],
             'endDate'           =>  ['required'],
         ]);*/
/*
        $type=$request->query("type");
        $requestType=$request->query("requestType");
        $requestStatus=$request->query("requestStatus");
        $startDate=$request->query("startDate");
        $endDate=$request->query("endDate");
        */
        $type=$request->type;
        $requestType=$request->requestType;
        $requestStatus=$request->requestStatus;
        $startDate=$request->startDate;
        $endDate=$request->endDate;

        if($type == "PROJECT"){
            $project = Project::find($request->projectId);
            if(is_object($project)){
                $requestForms = $project->requestForms()
                    ->whereIn('type',$requestType)
                    ->whereIn('approvalStatus',$requestStatus)
//                    ->where('dateRequested','>=',$startDate)
//                    ->where('dateRequested','<=',$endDate)
                    ->where('approvedDate','>=',$startDate)
                    ->where('approvedDate','<=',$endDate)
                    ->get();

            }else {
                if ((new AppController())->isApi($request)) {
                    //API Response
                    return response()->json(['message' => "Project not found"], 404);
                }else{
                    //Web Response
                    return Redirect::back()->with('error','Project not found');
                }
            }

        }else if($type == "VEHICLE"){
            $vehicle = Vehicle::find($request->vehicleId);
            if(is_object($vehicle)){
                $requestForms = $vehicle->requestForms()
                    ->whereIn('type',$requestType)
                    ->whereIn('approvalStatus',$requestStatus)
//                    ->where('dateRequested','>=',$startDate)
//                    ->where('dateRequested','<=',$endDate)
                    ->where('approvedDate','>=',$startDate)
                    ->where('approvedDate','<=',$endDate)
                    ->get();

            }else {
                if ((new AppController())->isApi($request)) {
                    //API Response
                    return response()->json(['message' => "Vehicle not found"], 404);
                }else{
                    //Web Response
                    return Redirect::back()->with('error','Vehicle not found');
                }
            }

        }else if($type == "USER"){
            $user = User::find($request->userId);
            if(is_object($user)){
                $requestForms = $user->requestForms()
                    ->whereIn('type',$requestType)
                    ->whereIn('approvalStatus',$requestStatus)
//                    ->where('dateRequested','>=',$startDate)
//                    ->where('dateRequested','<=',$endDate)
                    ->where('approvedDate','>=',$startDate)
                    ->where('approvedDate','<=',$endDate)
                    ->get();

            }else {
                if ((new AppController())->isApi($request)) {
                    //API Response
                    return response()->json(['message' => "User not found"], 404);
                }else{
                    //Web Response
                    return Redirect::back()->with('error','User not found');
                }
            }

        }else{
            $requestForms = RequestForm::whereIn('type',$requestType)
                ->whereIn('approvalStatus',$requestStatus)
//                    ->where('dateRequested','>=',$startDate)
//                    ->where('dateRequested','<=',$endDate)
                ->where('approvedDate','>=',$startDate)
                ->where('approvedDate','<=',$endDate)
                ->get();
        }

        $data=[];
        foreach ($requestForms as $requestForm) {
            if ($requestForm->type == "FUEL")
                $amount = $requestForm->fuelRequestedMoney;
            else
                $amount = $requestForm->total;

            $data[] = [
                'Code'              => $requestForm->code,
                'Approved Date'     => date("j/m/Y",$requestForm->approvedDate),
                'Description'       => $requestForm->type,
                'Amount'            => $amount,
                'Project'           => $requestForm->project != null? $requestForm->project->name: "",
                'Vehicle'           => $requestForm->vehicle != null? $requestForm->vehicle->vehicleRegistrationNumber: "",
                'Status'            => $this->getApprovalStatus($requestForm->approvalStatus),
                'Requested Date'    => date("j/m/Y",$requestForm->dateRequested),
                'Requested By'      => $requestForm->user->firstName." ".$requestForm->user->middleName." ".$requestForm->user->lastName,
            ];
        }
        $filename = "Requests-Export-".date("d-m-Y-H-i").".xlsx";
        return Excel::download(new RequestsExport($data),$filename);

    }
    private function getApprovalStatus($status){
        switch ($status){
            case 0:
                return "Pending";
            case 2:
                return "Denied";
            case 1:
                return "To be initiated";
            case 3:
                return "To be reconciled";
            case 4:
                return "Reconciled";
            case 5:
                return "Discarded";
            default:
                return "Unknown";
        }
    }
}
