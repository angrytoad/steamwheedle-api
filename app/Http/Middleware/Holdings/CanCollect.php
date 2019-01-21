<?php

namespace App\Http\Middleware\Holdings;

use App\Models\UserHolding;
use Closure;

class CanCollect
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
        // Validate the request
        $request->validate([
            'user_holding_ids' => 'required'
        ]);
        $ids = $request->get('user_holding_ids');
        if (!is_array($ids)) {
            return response()->json(['message' => 'This should be an array.'], 422);
        }

        // Check that the user owns all of these UserHoldings
        foreach ($ids as $userHolding) {
            $userHolding = UserHolding::find($userHolding);
            if (empty($userHolding)) {
                return response()->json(['message' => 'Something does not exist.'], 422);
            }
            if ($userHolding->user_id !== $request->user()->id) {
                return response()->json(['message' => 'Something is not yours.'], 422);
            }
        }

        return $next($request);
    }
}
