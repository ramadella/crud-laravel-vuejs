<?php

namespace App\Http\Middleware;

use App\Exceptions\InvalidCredentialsException;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check() || !in_array(auth()->user()->role, $roles)) {
            return InvalidCredentialsException::sendForbidden('Unauthorized Access');
        }

        return $next($request);
    }
}