<?php

namespace App\Listeners;

use Log;
use App\Events\TestEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * [TestEventListener events -- 事件监听器]
 */
class TestEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TestEvent  $event
     * @return void
     */
    public function handle(TestEvent $event)
    {
        Log::info('App\Listeners\TestEventListener');

        Log::info($event->user->toArray()); // 访问 $event->user 来访问 user
    }
}
