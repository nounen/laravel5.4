<?php

namespace App\Jobs;

use App\User;
use Log;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

/**
 * [SendReminderEmail 队列案例]
 */
class SendReminderEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    protected $type;

    /**
     * Create a new job instance. 一般是传参(传model)用的
     *
     * @return void
     */
    public function __construct(User $user, $type = 'normal')
    {
        $this->user = $user;

        $this->type = $type;
    }

    /**
     * Execute the job. 具体任务
     *
     * @return void
     */
    public function handle()
    {
        Log::info("queue job: {$this->type}");

        Log::info($this->user->toArray());
    }
}
