<?php

namespace App\Http\Middleware\Holdings;

use App\Models\Holding;
use Closure;

class DoesNotOwn
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
        if (empty(Holding::find($request->get('holding_id')))) {
            return response()->json(['message' => 'There is no such holding.'], 422);
        }
        $holdings = $request->user()->holdings;
        foreach ($holdings as $userHolding) {
            if ($userHolding->holding->id === $request->get('holding_id')) {
                return response()->json(['message' => 'You already have this'], 422);
            }
        }
        return $next($request);
    }
}
