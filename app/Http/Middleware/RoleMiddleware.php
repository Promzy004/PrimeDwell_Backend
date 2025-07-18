<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {

        $user = $request->user();
        if(!$user){
            return response()->json([
                'message' => 'You need to login bitch ass user'
            ]);
        }

        if(!in_array($user->role, $roles)){
            return response()->json([
                'message' => 'unauthorized!!!'
            ]);
        }
        return $next($request);
    }
}
