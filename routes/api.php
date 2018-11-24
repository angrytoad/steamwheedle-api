<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

$this->group(['middleware' => [], 'prefix' => '/test'], function() {
    $this->get('/','Test\TestController@test');
});

$this->group(['middleware' => [], 'prefix' => '/user'], function() {
    $this->post('/register','User\RegisterController@post');
    $this->post('/login','User\LoginController@login');
});
