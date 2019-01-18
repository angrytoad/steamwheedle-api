<?php

namespace App\Http\Middleware\Holdings;

use Closure;

class ValidateHoldingPurchase
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
            'holding_id' => 'required|uuid'
        ]);
        return $next($request);
    }
}
