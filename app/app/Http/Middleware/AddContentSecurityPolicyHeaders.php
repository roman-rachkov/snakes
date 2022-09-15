<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Vite;
use Illuminate\Http\Request;

class AddContentSecurityPolicyHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        Vite::useCspNonce();

        return $next($request)->withHeaders([
            'Content-Security-Policy' => 'script-src \'nonce-' . Vite::cspNonce() . '\''
        ]);
    }
}
