<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->query('apiKey');
        if ($apiKey !== '4724996b313a37f7311755961372e14c') {
            return abort(403);
            // return response()->json(['message' => 'Unauthorized'], 401);
        }
        return $next($request);
    }
}
