<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JsonRequestMiddleware
{
    /**
     * Check if the request has Content-Type:application/json
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->isJson()) {
            return response()->error('Content-Type must be application/json');
        }

        return $next($request);
    }
}
