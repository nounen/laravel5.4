<?php

namespace App\Providers;

use Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use View;
use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Queue\Events\JobFailed;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 共享数据到所有视图
        View::share('key', 'value');

        // https://laravel-news.com/laravel-5-4-key-too-long-error
        Schema::defaultStringLength(191);

        // queues -- 任务事件
        Queue::before(function (JobProcessing $event) {
            Log::info("Queue::before");
        });

        Queue::after(function (JobProcessed $event) {
            Log::info("Queue::after");
        });

        Queue::failing(function (JobFailed $event) {
            Log::info("Queue::failing");
        });

        // database 监听查询事件: http://d.laravel-china.org/docs/5.4/database#监听查询事件
        DB::listen(function ($query) {
            Log::debug([
                'sql'      => $query->sql,
                'bindings' => $query->bindings,
                'time'     => $query->time,
            ]);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
