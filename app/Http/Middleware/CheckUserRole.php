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
    public function handle(Request $request, Closure $next, string ...$role): Response
    {
        $userRole = Auth::user()->role;

        if($userRole == Role::NON_ACTIF)
            return response()->json(['message' => 'Unauthorized'], 401);

        if($userRole == Role::ADMIN)
            return $next($request);

        foreach ($role as $r) {
            if ($r == Role::ADMIN && $userRole != Role::ADMIN) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            if ($userRole == $r || ($userRole == Role::GESTIONNAIRE && $r != Role::ADMIN)) {
                return $next($request);
            }
        }
        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
