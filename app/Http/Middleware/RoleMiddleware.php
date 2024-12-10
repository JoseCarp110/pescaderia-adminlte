<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
    if (auth()->user() && auth()->user()->role == $role) {
        return $next($request);
    }

    return redirect('/home')->with('ERROR', 'No tienes permiso para acceder a esta página.');
    }
   
}
