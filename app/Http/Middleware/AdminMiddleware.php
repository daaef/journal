<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('auth.login.get');
        }

        // Check if user has admin role
        if (!auth()->user()->hasRole('Admin')) {
            $notification = array(
                'message' => 'You are not authorized to access this page',
                'alert-type' => 'error'
            );
            return redirect()->route('home')->with($notification);
        }

        return $next($request);
    }
}
