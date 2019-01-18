<?php

namespace App\Http\Middleware\Holdings;

use App\Models\UserHolding;
use Closure;

class DoesOwn
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
        $userHolding = UserHolding::find($request->get('user_holding_id'));
        if (empty($userHolding)) {
            return response()->json(['message' => 'There is no such holding.'], 422);
        }
        if ($request->user()->id !== $userHolding->user->id) {
            return response()->json(['message' => 'This is not yours'], 422);
        }
        return $next($request);
    }
}
