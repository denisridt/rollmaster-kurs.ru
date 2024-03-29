<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && $request->user()->role_id === 2) {
            return $next($request);
        }

        abort(403, 'У вас нет доступа к этой странице.');
    }
}
