<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PageController extends Controller
{
    public function dashboard()
    {
        return Inertia::render('Dashboard');
    }

    public function index()
    {
        return Inertia::render('Index');
    }

    public function approved()
    {
        return Inertia::render('Approved');
    }

    public function finance()
    {
        return Inertia::render('Finance');
    }

    public function users()
    {
        $users=User::orderBy('firstName')->get();
        return Inertia::render('Users/Index',[
            'users' =>  UserResource::collection($users)
        ]);
    }

    public function usersShow($id)
    {
        return Inertia::render('Users/Show',[
//            'users' =>  UserResource::collection($users)
        ]);
    }

    public function projects()
    {
        $projects=Project::orderBy('name','asc')->get();
        return Inertia::render('Projects/Index',[
           'projects'   =>  $projects
        ]);
    }

    public function projectsShow($id)
    {
        return Inertia::render('Projects/Show',[
//            'project' =>
        ]);
    }
}
