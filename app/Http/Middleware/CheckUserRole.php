<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()->role === Role::NON_ACTIF) {
            return $next($request);
        }
        throw new \HttpResponseException(response()->json(json_encode([
            'message' => "The user {$request->user()->name} can't access to this endpoint"
        ]), RESPONSE::HTTP_FORBIDDEN));
    }
}
