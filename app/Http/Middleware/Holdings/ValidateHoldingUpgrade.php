<?php

namespace App\Http\Middleware\Holdings;

use Closure;

class ValidateHoldingUpgrade
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
        $request->validate([
            'user_holding_id' => 'required|uuid',
            'type' => 'required|string'
        ]);
        return $next($request);
    }
}
