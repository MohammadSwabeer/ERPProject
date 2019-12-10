<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Redirect;
use Illuminate\Support\Facades\Auth;

class LoginMiddleware
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
        // Session::has('email') //using session
        if (Auth::guard('admin')->user()) {
            return redirect()->route('admin-home');
        }

        $response = $next($request);
        $response->headers->set('Cache-Control','nocache, no-store, max-age=0, must-revalidate'); 
        $response->headers->set('Pragma','no-cache'); 
        $response->headers->set('Expires','Fri, 01 Jan 1990 00:00:00 GMT');
        return $response;
    }
}
