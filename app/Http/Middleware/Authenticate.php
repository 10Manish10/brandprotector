<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        $method = $request->method();
        $route = $request->route()->getName();
        if ($method == "POST" && $route == "plans.paymentWebhook") {
            return null;
        }
        return $request->expectsJson() ? null : route('login');
    }
}
