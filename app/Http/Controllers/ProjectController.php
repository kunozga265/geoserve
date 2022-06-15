<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $user=(new AppController())->getAuthUser($request);

        if($user->hasRole('management') || $user->hasRole('administrator')){
            $projects= Project::orderBy('name','asc')->get();
        }else
            $projects= Project::orderBy('name','asc')->where('verified',1)->get();

        return response()->json(ProjectResource::collection($projects));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
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

        return response()->json(new ProjectResource($project));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $project=Project::find($id);

        if (is_object($project))
            return response()->json(new ProjectResource($project));
        else
            return response()->json(['message'=>'Project not found'],404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $project=Project::find($id);

        if (is_object($project)){

            if($project->verified)
                return response()->json(['message'=>'Project is not editable'],404);

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

            return response()->json(new ProjectResource($project));
        }
        else
            return response()->json(['message'=>'Project not found'],404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(Request $request, $id)
    {
        $project=Project::find($id);

        if (is_object($project)){

            $project->update([
                "verified"  =>  true,
            ]);

            return response()->json(new ProjectResource($project));
        }
        else
            return response()->json(['message'=>'Project not found'],404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $project=Project::find($id);

        if (is_object($project)){

            if($project->verified)
                return response()->json(['message'=>'Project cannot be deleted'],404);

            $project->delete();

            return response()->json(['message'=>'Project has been deleted']);

        } else
            return response()->json(['message'=>'Project not found'],404);
    }
}
