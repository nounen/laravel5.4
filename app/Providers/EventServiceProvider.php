<?php

namespace App\Providers;

use Log;
use App\Listeners\UserEventSubscriber;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],

        // authentication -- 登陆成功事件监听
        'Illuminate\Auth\Events\Login' => [
            'App\Listeners\LogSuccessfulLogin',
        ],

        // events -- 事件(key) 和 监听器(value), 命名时要对应好命名空间才能在对应目录生成文件
        'App\Events\TestEvent' => [
            'App\Listeners\TestEventListener',
            // ... // 一个事件可以多个监听
        ],
    ];

    // 需要注册的订阅者类
    protected $subscribe = [
        UserEventSubscriber::class,
    ];
    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        // events -- 闭包注册事件
        Event::listen('event.test', function ($foo, $bar) {
            Log::info('event.test');
        });
    }
}
