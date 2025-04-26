<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureDoctorRole
{
    /**
     * Restrict access to users with the doctor role.
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && $request->user()->role === 'doctor') {
            return $next($request);
        }

        return response()->json(['message' => 'Forbidden: Doctor role required'], 403);
    }
}