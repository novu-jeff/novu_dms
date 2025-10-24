<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\AuditService;
use Illuminate\Http\Request;

class AuditMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if(auth()->check()) {
            $action = 'Visited Page';
            $description = $request->method() . ' ' . $request->fullUrl();
            AuditService::log($action, $description);
        }
        return $next($request);
    }
}
