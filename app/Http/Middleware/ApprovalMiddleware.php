<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Support\Facades\Gate;

class ApprovalMiddleware
{
    public function handle($request, Closure $next)
    {
        $method = $request->method();
        $route = $request->route()->getName();
        if ($method == "POST" && $route == "plans.paymentWebhook") {
            return $next($request);
        }
        if (auth()->check()) {
            if (! auth()->user()->approved) {
                auth()->logout();

                return redirect()->route('login')->with('message', trans('global.yourAccountNeedsAdminApproval'));
            }
        }

        return $next($request);
    }
}
