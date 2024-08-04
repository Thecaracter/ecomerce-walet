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
            $request->session()->flash('alert', [
                'type' => 'error',
                'message' => 'You must be logged in to access this page.',
            ]);

            return redirect()->route('login');
        }

        $user = Auth::user();

        // Example: Restrict access to admin users only
        if (!$user->hasRole('admin')) {
            $request->session()->flash('alert', [
                'type' => 'error',
                'message' => 'You do not have permission to access this page.',
            ]);

            return redirect()->route('home');
        }

        return $next($request);
    }
}
