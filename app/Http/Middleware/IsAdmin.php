<?php

namespace App\Http\Middleware;

use Closure;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if( get_class($request->user()->admin != true)){
            return response()->error("Not authorized to do this action",[], 403);
        }
        return $next($request);
    }
}
