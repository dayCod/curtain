<?php

declare(strict_types=1);

namespace Daycode\Curtain\Http\Middleware;

use Closure;
use Daycode\Curtain\Facades\Curtain;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CurtainMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $canAccess = Curtain::canAccessPath($request);

        if ($canAccess) {
            return $next($request);
        }

        return Curtain::render();
    }
}
