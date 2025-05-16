<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo;


    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @param string|null ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // If the request is for admin routes and user is authenticated as admin
                if ($request->is('admin/*') && $guard === 'admin_web') {
                    return redirect(RouteServiceProvider::ADMIN_HOME);
                }
                
                // For all other cases, redirect to the appropriate home page
                if ($guard === 'admin_web') {
                    return redirect(RouteServiceProvider::ADMIN_HOME);
                }
                
                $this->redirectTo = RouteServiceProvider::getHome();
                return redirect($this->redirectTo);
            }
        }

        return $next($request);
    }
}
