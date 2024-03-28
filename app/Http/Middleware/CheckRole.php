<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (in_array(auth()->user()->role_id, $roles)) {
            return $next($request);
        }

        return redirect('/redirect');
    }
}