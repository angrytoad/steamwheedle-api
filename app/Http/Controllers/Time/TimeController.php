<?php namespace App\Http\Controllers\Time;

/**
 * Created by PhpStorm.
 * User: alex
 * Date: 09/01/19
 * Time: 15:10
 */

use App\Models\Metric;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class TimeController extends Controller
{
    public function countdown()
    {
        $metric = Metric::orderBy('created_at','DESC')->first();

        $now = Carbon::now()->timestamp;
        $duration = $metric->updated_at->timestamp - $metric->created_at->timestamp;
        $nextUpdate = $metric->created_at->addSeconds(config('adjustment')['interval']);
        $nextUpdateSeconds = $metric->created_at->addSeconds(config('adjustment')['interval'])->timestamp - $now;

        return response()->json([
            'lastUpdate' => $metric->created_at,
            'duration' => $duration,
            'nextUpdate' => $nextUpdate,
            'nextUpdateSeconds' => $nextUpdateSeconds
        ], 200);
    }
}