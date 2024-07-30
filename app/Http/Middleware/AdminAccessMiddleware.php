<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class AdminAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */


    public function handle(Request $request, Closure $next)
    {
        if (!Gate::allows('admin')) {
            return response()->json([
                'error' => 'Unauthorized action',
                'message' => 'You do not have permission to access this resource.',
                'status_code' => 403
            ], 403);
        }

        return $next($request);
    }
}
