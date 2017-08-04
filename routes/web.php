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
// Auth::routes() 包含 'login', 'register' 等路由, 可以通过 php artisan route:list 查看
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


// vue
Route::get('/vue', function () {
    return view('vue.index');
});


// 任务清单
Route::get('/tasks', 'TaskController@index');
Route::post('/task', 'TaskController@store');
Route::delete('/task/{task}', 'TaskController@destroy');


// encryption
use Illuminate\Support\Facades\Crypt;

Route::get('/encryption', function() {
    $encrypted = Crypt::encryptString('Hello world.');
    $encryptedNew = encrypt('Hello world.');

    $decrypted = Crypt::decryptString($encrypted);
    $decryptedNew = decrypt($encryptedNew);

    dd($encrypted, $decrypted, $encryptedNew, $decryptedNew);
});


// cache -- 多标签操作
Route::get('/cache', function () {
    // Cache::tags(['people', 'artists'])->put('John', '$john', 90); // 设置标签 ['people', 'artists']

    // Cache::tags('people')->flush(); // 其中一个标签被清除 ['people', 'artists'] 就无法访问

    $name = Cache::tags(['people', 'artists'])->get('John');

    Cache::tags('test')->put('Test', '$Test', 90);
    $test = Cache::tags('test')->get('Test');

    dd($name, $test);
});
