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
use App\User;

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


// collections
Route::get('/collection', function () {
    $collection = collect(['taylor', 'abigail', null])->map(function ($name) {
        return strtoupper($name);
    })
    ->reject(function ($name) {
        return empty($name);
    });


    $total = collect([1, 2, 3])->reduce(function ($carry, $item) {
        \Log::debug("{$carry} + {$item}");

        return $carry + $item;
    });

    dd($collection, $total);
});


// errors -- 自定义异常
Route::get('/error_custom_exception', function () {
    throw new App\Exceptions\CustomException('抛出一个自定义异常', 99);
});


// events -- 事件
Route::get('/events', function () {
    $user = App\User::find(1);

    // 事件触发
    event(new App\Events\TestEvent($user));
});


// filesystem
Route::get('/filesystem', function () {
    \Storage::disk('local')->put('file.txt', 'Contents');

    $url = Storage::url('file1.jpg');

    $storagePath = storage_path();

    dd($url, $storagePath);
});


// mail
Route::get('/mail', function () {
    $user = App\User::find(2);

    \Mail::to($user)->send(new App\Mail\OrderShipped($user));
});

Route::get('/mail_markdown', function () {
    $user = App\User::find(2);

    \Mail::to($user)->send(new App\Mail\MarkdownMail());
});


// notifications
Route::get('/notification', function () {
    $user = App\User::find(2);

    $user->notify(new App\Notifications\InvoicePaid());

    // 发送通知方式 2 (群发)
    $users = App\User::whereIn('id', [2, 3])->get();

    Notification::send($users, new App\Notifications\InvoicePaid());
});

Route::get('/create_database_notify', function () {
    $user = App\User::find(2);

    // 消息定义通知写入数据库
    $user->notify(new App\Notifications\NewUserFollowNotification());
});

Route::get('/read_database_notify', function () {
    $user = App\User::find(2);

    // 消息查看
    // foreach ($user->notifications as $notification) {    // 所有消息
    foreach ($user->unreadNotifications as $notification) { // 所有未读消息
        dump($notification->type);
        dump($notification->data['name']); // 消息数据

        $notification->markAsRead(); // 消息标记为已读
    }
});


// queues -- 立即执行
Route::get('/queue', function () {
    $user = App\User::find(2);

    // 立即执行
    dispatch(new App\Jobs\SendReminderEmail($user));
});

// queues -- 延迟执行
Route::get('/queue_delay', function () {
    $user = App\User::find(2);

    // 延迟分发
    $job = (new App\Jobs\SendReminderEmail($user, 'delay'))->delay(Carbon\Carbon::now()->addMinutes(1));
    dispatch($job);
});

// queues -- 分发任务到指定队列
Route::get('/queue_on_queue', function () {
    $user = App\User::find(2);

    // 分发任务到指定队列
    $job = (new App\Jobs\SendReminderEmail($user, 'on_queue'))->onQueue('processing');

    dispatch($job);
});

// queues -- 分发任务到指定连接
Route::get('/queue_on_connection', function () {
    $user = App\User::find(2);

    // 分发任务到指定连接 -- redis
    $job = (new App\Jobs\SendReminderEmail($user, 'on_connection_redis'))->onConnection('redis');

    // 分发任务到指定连接 -- sync, 同步连接, 立即执行
    // $job = (new App\Jobs\SendReminderEmail($user, 'on_connection_sync'))->onConnection('sync');

    dispatch($job);
});

// queues -- 伪造处理失败的任务
Route::get('/queue_failed', function () {
    $user = App\User::find(2);

    // 立即执行
    dispatch(new App\Jobs\FakeFailedTask($user, 'queue_failed'));
});


// queries
Route::get('/queries', function () {
    $list = App\User::get();

    $name = DB::table('users')->value('name');

    $names = DB::table('users')->pluck('name');

    $namesArr = DB::table('users')->pluck('name', 'email');

    dd($list, $name, $names, $namesArr);
});

// queries -- cross jon
Route::get('/queries_cross_join', function () {
    $list = DB::table('users')
                ->crossJoin('posts')
                ->get();

    dd($list);
});


// redis
Route::get('/redis_publish', function () {
    Redis::publish('test-channel', json_encode(['foo' => 'bar']));
});


// 全局作用域
Route::get('/global_scope', function () {
    $list = App\User::get();

    dd(\DB::getQueryLog());
});


Route::get('/eloquent_observe', function () {
    $item = App\User::find(1);
    $item->name = $item->name . '_observe';
    $item->save();
});


// 修改器
Route::get('/eloquent_mutators_getter', function () {
    $item = App\User::find(1);

    dd($item->first_name); // 获取器获取不存在得模型字段
});

Route::get('/eloquent_mutators_setter', function () {
    $item = App\User::find(1);
    $item->name = 'TEST'; // 会被修改器作用
    $item->save();
});
