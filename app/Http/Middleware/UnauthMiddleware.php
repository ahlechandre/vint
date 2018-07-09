<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class UnauthMiddleware
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

        // Doesn't allow authenticated users.
        if (Auth::check()) {
            return redirect('/dashboard');
        }

        return $next($request);
    }
}
