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

Route::middleware(['auth:api'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:api'])->get('/levels', function (Request $request) {
    return config('levels');
});

$this->group(['middleware' => [], 'prefix' => '/test'], function() {
    $this->get('/','Test\TestController@test');
});

$this->group(['middleware' => [], 'prefix' => '/user'], function() {
    $this->post('/register','User\RegisterController@post');
    $this->post('/login','User\LoginController@login');
});

$this->group(['middleware' => ['auth:api'], 'prefix' => 'auction'], function () {
    $this->get('/categories', 'Category\CategoryController@fetch');
    $this->get('/update', 'TimeController@countdown');

    $this->group(['middleware' => 'json'], function () {
        $this->post('/items', 'Item\ItemController@filter');;
        $this->post('/buy', 'Item\TradeController@buy')->middleware('has-funds');
        $this->post('/sell', 'Item\TradeController@sell')->middleware('has-stock');
    });
});

$this->group(['middleware' => 'auth:api'], function () {
    $this->group(['prefix' => 'user'], function () {
        $this->get('/purchases', 'User\PurchasesController@purchases');
    });
});