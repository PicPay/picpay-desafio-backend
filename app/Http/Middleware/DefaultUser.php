<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DefaultUser
{
    /**
     * Handle an incoming request.
     *
     * @param Request  $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::user()->default()) {
            return redirect('home');
        }
        return $next($request);
    }
}
