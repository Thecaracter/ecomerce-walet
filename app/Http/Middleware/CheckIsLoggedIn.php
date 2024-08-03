<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckIsLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            // Set a session variable for error message
            $request->session()->flash('alert', [
                'type' => 'error',
                'message' => 'You must be logged in to access this page.',
            ]);

            // Redirect to login page
            return redirect()->route('login');
        }

        return $next($request);
    }
}
