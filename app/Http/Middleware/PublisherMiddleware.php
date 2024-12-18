<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PublisherMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!auth()->user()->hasRole('Author')){
            $notification = array(
                'message' => 'You are not authorized to access this page',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
        return $next($request);
    }
}
