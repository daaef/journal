<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReviewerMiddleware
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

        // Check if user has reviewer role (Associate Editor or Desk Editor)
        if (!auth()->user()->hasRole('Associate Editor') && !auth()->user()->hasRole('Desk Editor')) {
            $notification = array(
                'message' => 'You are not authorized to access this page',
                'alert-type' => 'error'
            );
            return redirect()->route('home')->with($notification);
        }

        return $next($request);
    }
}
