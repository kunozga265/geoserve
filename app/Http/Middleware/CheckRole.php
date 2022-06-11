<?php

namespace App\Http\Middleware;

use App\Http\Controllers\AppController;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $actions=$request->route()->getAction();
        $roles=isset($actions['roles'])?$actions['roles']:null;

        $user=(new AppController())->getAuthUser($request);

        if($user->hasAnyRole($roles)||!$roles){
            return $next($request);
        }else
            return response()->json([ 'message'=>'Unauthorized. Does not have access rights.'],403);
    }
}
