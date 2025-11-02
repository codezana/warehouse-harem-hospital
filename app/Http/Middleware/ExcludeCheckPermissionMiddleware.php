<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExcludeCheckPermissionMiddleware
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
        // Exclude certain routes from permission check
        if ($request->route()->getName() === 'request.page' || 
            $request->route()->getName() === 'submitOrder' || 
            $request->route()->getName() === 'store_requests' || 
            $request->route()->getName() === 'dashboard') {
            return $next($request);
        }

        // Pass the request to the CheckAnyPermission middleware
        return app(\App\Http\Middleware\CheckAnyPermission::class)->handle($request, $next);
    }
}
