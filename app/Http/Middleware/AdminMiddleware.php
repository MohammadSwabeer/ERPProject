<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guard('admin')->guest()){
            return ($request->ajax()) ? response('Unauthorized.', 401) : redirect()->guest('/');
        }
        $response =  $next($request);
        $response->headers->set('Cache-Control','nocache, no-store, max-age=0, must-revalidate'); 
        $response->headers->set('Pragma','no-cache'); 
        $response->headers->set('Expires','Fri, 01 Jan 1990 00:00:00 GMT');
        return $next($request);
    }
}
