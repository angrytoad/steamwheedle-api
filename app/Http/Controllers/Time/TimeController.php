<?php namespace App\Http\Controllers\Time;

/**
 * Created by PhpStorm.
 * User: alex
 * Date: 09/01/19
 * Time: 15:10
 */

use App\Models\Metric;
use App\Http\Controllers\Controller;

class TimeController extends Controller
{
    public function countdown()
    {
        $metric = Metric::orderBy('created_at')->first();
        return response()->json([
            'time' => $metric->created_at,
            'duration' => $metric->updated_at - $metric->created_at
        ], 200);
    }
}