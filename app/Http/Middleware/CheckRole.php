<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Check user's role (adjust based on your user model structure)
        $user = Auth::user();
        
        // If your user model has a 'role' field
        if ($user->role !== $role) {
            abort(403, 'Unauthorized access.');
        }

        // If you're using roles table via relationships
        // if (!$user->hasRole($role)) {
        //     abort(403, 'Unauthorized access.');
        // }

        return $next($request);
    }
}