<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{

    public function handle(Request $request, Closure $next, $permission)
    {

        $user = $request->user();

        if(!$user){
            return response()->json([
                'message'=>'Unauthorized'
            ],401);
        }

        $roles = $user->roles;

        foreach($roles as $role){

            foreach($role->permissions as $perm){

                if($perm->name == $permission){
                    return $next($request);
                }

            }

        }

        return response()->json([
            'message'=>'Permission Denied'
        ],403);

    }

}
