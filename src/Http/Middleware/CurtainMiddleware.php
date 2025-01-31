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
        if (Curtain::isDownForMaintenance() && ! $this->shouldPassThrough($request)) {
            return Curtain::render();
        }

        return $next($request);
    }

    protected function shouldPassThrough(Request $request): bool
    {
        if ($request->is(config('curtain.excluded_paths', []))) {
            return true;
        }

        if (Curtain::hasValidBypassToken($request)) {
            return true;
        }

        return $this->isAllowedIp($request->ip());
    }

    protected function isAllowedIp(?string $ip): bool
    {
        return in_array($ip, config('curtain.allowed_ips', []));
    }
}
