<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Http\Resources\RequestFormResource;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user=(new AppController())->getAuthUser($request);

        if($user->hasRole('management') || $user->hasRole('administrator')){
            $projects= Project::orderBy('name','asc')->get();

        }else {
            $projects = Project::orderBy('name', 'asc')->where('verified', 1)->get();
        }


        if ((new AppController())->isApi($request))
            //API Response
            return response()->json(ProjectResource::collection($projects));
        else{
            //Web Response
            return Inertia::render('Projects/Index',[
                'projects'     =>  ProjectResource::collection($projects),
            ]);
        }
    }

    public function create(Request $request)
    {
        return Inertia::render('Projects/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $request->validate([
           "name"       =>  ['required'],
           "client"     =>  ['required'],
           "site"       =>  ['required'],
        ]);

        $project=Project::create([
            "name"       =>  $request->name,
            "client"     =>  $request->client,
            "site"       =>  $request->site,
            "verified"   =>  false,
        ]);

        //Run notifications
        (new NotificationController())->notifyManagement($project,"PROJECT_NEW");

        //Add to report
        $report=(new ReportController())->getCurrentReport();
        $report->projects()->attach($project);

        if ((new AppController())->isApi($request)) {
            //API Response
            return response()->json(new ProjectResource($project));
        }else{
            //Web Response
            return Redirect::route('projects')->with('success','Project created');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show(Request $request,$id)
    {
        $project=Project::find($id);

        if (is_object($project)) {
            $totalRequests=$project->requestForms->count();

            //For Pie Chart
            $cashRequestsCount=$project->requestForms()->where('type','CASH')->count();
            $materialsRequestsCount=$project->requestForms()->where('type','MATERIALS')->count();
            $vehicleMaintenanceRequestsCount=$project->requestForms()->where('type','VEHICLE_MAINTENANCE')->count();
            $fuelRequestsCount=$project->requestForms()->where('type','FUEL')->count();

            //Page Info
            $approvedRequestsCount=$project->requestForms()->where('approvalStatus','>',0)->where('approvalStatus','<',4)->where('approvalStatus','!=',2)->count();
            $pendingRequestsCount=$project->requestForms()->where('approvalStatus',0)->count();
            $deniedRequestsCount=$project->requestForms()->where('approvalStatus',2)->count();
            $closedRequestsCount=$project->requestForms()->where('approvalStatus','>',3)->count();

            //Requests section
            $activeRequests=$project->requestForms()->where('approvalStatus','<',4)->orderBy('dateRequested','desc')->get();
            $closedRequests=$project->requestForms()->where('approvalStatus','>',3)->orderBy('dateRequested','desc')->get();

            $response=[
                'project'                           => new ProjectResource($project),
                'totalRequests'                     => $totalRequests,
                'cashRequestsCount'                 => $cashRequestsCount,
                'materialsRequestsCount'            => $materialsRequestsCount,
                'vehicleMaintenanceRequestsCount'   => $vehicleMaintenanceRequestsCount,
                'fuelRequestsCount'                 => $fuelRequestsCount,
                'approvedRequestsCount'             => $approvedRequestsCount,
                'pendingRequestsCount'              => $pendingRequestsCount,
                'deniedRequestsCount'               => $deniedRequestsCount,
                'closedRequestsCount'               => $closedRequestsCount,
                'activeRequests'                    => RequestFormResource::collection($activeRequests),
                'closedRequests'                    => RequestFormResource::collection($closedRequests),
            ];

            if ((new AppController())->isApi($request))
                //API Response
                return response()->json($response);
            else{
                //Web Response
                return Inertia::render('Projects/Show',$response);
            }
        }
        else {
            if ((new AppController())->isApi($request)) {
                //API Response
                return response()->json(['message' => 'Project not found'], 404);
            }else{
                //Web Response
                return Redirect::back()->with('error','Project not found');
            }
        }
    }

    public function edit(Request $request,$id)
    {
        $project=Project::find($id);

        if (is_object($project)) {

            if($project->verified) {
                return Redirect::back()->with('error','Project is not editable');
            }

            return Inertia::render('Projects/Edit',[
                'project' => new ProjectResource($project)
            ]);
        }
        else {
            return Redirect::back()->with('error','Project not found');
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, $id)
    {
        $project=Project::find($id);

        if (is_object($project)){

            if($project->verified) {
                if ((new AppController())->isApi($request)) {
                    //API Response
                    return response()->json(['message' => 'Project is not editable'], 404);
                }else{
                    //Web Response
                    return Redirect::back()->with('error','Project is not editable');
                }
            }

            $request->validate([
                "name"       =>  ['required'],
                "client"     =>  ['required'],
                "site"       =>  ['required'],
            ]);

            $project->update([
                "name"       =>  $request->name,
                "client"     =>  $request->client,
                "site"       =>  $request->site,
            ]);

            if ((new AppController())->isApi($request)) {
                //API Response
                return response()->json(new ProjectResource($project));
            }else{
                //Web Response
                return Redirect::route('projects')->with('success','Project updated');
            }
        }
        else {
            if ((new AppController())->isApi($request)) {
                //API Response
                return response()->json(['message' => 'Project not found'], 404);
            }else{
                //Web Response
                return Redirect::back()->with('error','Project not found');
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function verify(Request $request, $id)
    {
        $project=Project::find($id);

        if (is_object($project)){

            $project->update([
                "verified"  =>  true,
            ]);

            if ((new AppController())->isApi($request)) {
                //API Response
                return response()->json(new ProjectResource($project));
            }else{
                //Web Response
                return Redirect::route('projects')->with('success','Project Verified');
            }
        }
        else{
            if ((new AppController())->isApi($request)) {
                //API Response
                return response()->json(['message' => 'Project not found'], 404);
            }else{
                //Web Response
                return Redirect::back()->with('error','Project not found');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy(Request $request,$id)
    {
        $project=Project::find($id);

        if (is_object($project)){

            if($project->verified) {
                if ((new AppController())->isApi($request)) {
                    //API Response
                    return response()->json(['message'=>'Project cannot be deleted'],404);
                }else{
                    //Web Response
                    return Redirect::back()->with('error','Project cannot be deleted');
                }
            }

            $project->delete();

            if ((new AppController())->isApi($request)) {
                //API Response
                return response()->json(['message'=>'Project has been deleted']);
            }else{
                //Web Response
                return Redirect::route('projects')->with('success','Project has been deleted');
            }


        } else {
            if ((new AppController())->isApi($request)) {
                //API Response
                return response()->json(['message' => 'Project not found'], 404);
            }else{
                //Web Response
                return Redirect::back()->with('error','Project not found');
            }
        }
    }
}
