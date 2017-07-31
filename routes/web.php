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


// passport
Route::get('/passport', function () {
    return view('vue.passport');
});

// passport -- 授权时的重定向
Route::get('/redirect', function () {
    $query = http_build_query([
        'client_id' => '3',
        'redirect_uri' => 'http://www.laravel54.dev/callback',
        'response_type' => 'code',
        'scope' => '',
    ]);

    return redirect('http://www.laravel54.dev/oauth/authorize?'.$query);
});

// passport -- 将授权码转换为访问令牌
Route::get('/callback', function (Request $request) {
    $http = new \GuzzleHttp\Client;

    $response = $http->post('http://www.laravel54.dev/oauth/token', [
        'form_params' => [
            'grant_type' => 'authorization_code',
            'client_id' => '3',
            'client_secret' => 'xIbkkpJabogMvylwhO95P3RzWeVaVRJRDVDwD4ab',
            'redirect_uri' => 'http://www.laravel54.dev/callback',
            'code' => $request->code,
        ],
    ]);

    return json_decode((string) $response->getBody(), true);
});
