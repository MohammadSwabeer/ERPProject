<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        try {
            switch ($guard) {
                case 'admin':
                        if (Auth::guard($guard)->check()) {
                            return redirect('admin/index');
                        }
                    break;
                
                default:
                    if (Auth::guard($guard)->check()) {
                        return redirect('/home');
                    }
                    break;
            }
            return $next($request);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
