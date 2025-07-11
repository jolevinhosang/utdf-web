<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        if (!Auth::check()) {
            return redirect()->route('admin.login')->with('error', 'Please login to access the admin panel.');
        }

        // You can add additional admin checks here
        // For example, check if user has admin role
        if (!in_array(Auth::user()->role, ['admin', 'superadmin'])) {
            return redirect()->route('welcome')->with('error', 'Access denied.');
        }

        return $next($request);
    }
}
