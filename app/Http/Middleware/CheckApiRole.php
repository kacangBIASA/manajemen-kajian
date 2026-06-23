<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckApiRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check() || auth()->user()->role !== $role) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Akses ditolak.',
                'data'    => null,
            ], 403);
        }

        return $next($request);
    }
}
