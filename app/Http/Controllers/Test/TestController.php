<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 24/11/2018
 * Time: 00:32
 */
namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;

class TestController extends Controller
{

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {

    }

    public function test()
    {
        return response()->json([
            'foo' => 'bar'
        ]);
    }
}
