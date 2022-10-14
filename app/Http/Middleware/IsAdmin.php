<?php

namespace App\Http\Middleware;

use Closure;

class IsAdmin
{

    public function handle($request, Closure $next)
    {

        if (auth()->check()) {
            if (auth()->user()->is_admin == 1) return $next($request);
            return abort(403);

        }
        return abort(401);
    }

}
