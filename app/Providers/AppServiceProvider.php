<?php

namespace App\Providers;

use Log;
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
