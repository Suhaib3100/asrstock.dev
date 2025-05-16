<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            // Determine the guard and redirect to the appropriate login route
            if ($request->is('admin/*')) {
                return route('admin.login');
            }

            if ($request->is('customer/*')) {
                return route('login');
            }

            // Default login route
            return route('login');
        }
    }
}
