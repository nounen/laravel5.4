<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/test_contract', 'TestContractController@index');

// $request->intersect 例子
Route::get('/requests', function(Request $request) {
    $input = $request->get('username');

    $realInput = $request->intersect(['username', 'password']);

    dd($input, $realInput);
});

// 响应宏
Route::get('/macro', function() {
    return response()->caps('foo');
});

// 视图合成器
Route::get('/composer', function() {
    return view('profile', ['name' => 'Victoria']);
});

// authentication
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/get_auth', 'HomeController@getAuth');

// authentication -- HTTP 基础认证
Route::get('/auth_basic', function () {
    dd(\Auth::user()->toArray());
})->middleware('auth.basic');

// authentication -- 无状态 HTTP 基础认证
Route::get('/api/user', function () {
    dd(\Auth::user()->toArray());
})->middleware('auth.basic.once');
