<?php

namespace App\Http\Middleware;

use Closure;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LastLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            // dd(new DateTime());
            Auth::user()->update(['last_login' => now()]);
            // $user = $request->user();
            // $user->last_login = now();
            // $user->save();
        }
        return $next($request);
    }
}
