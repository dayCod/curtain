<?php

declare(strict_types=1);

namespace Daycode\Curtain\Http\Middleware;

use Closure;
use Daycode\Curtain\Facades\Curtain;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CurtainMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $canAccess = Curtain::canAccessPath($request);
        // dd($canAccess);

        if ($canAccess) {
            return $next($request);
        }

        return Curtain::render();
    }
}
