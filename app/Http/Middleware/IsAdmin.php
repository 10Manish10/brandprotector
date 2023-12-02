<?php

namespace App\Http\Middleware;

use Closure;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $method = $request->method();
        $route = $request->route()->getName();
        if ($method == "POST" && $route == "plans.paymentWebhook") {
            return $next($request);
        }
        if (! auth()->user()->is_admin) {
            abort(403);
        }

        return $next($request);
    }
}
