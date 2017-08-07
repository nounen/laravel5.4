<?php

namespace App\Jobs;

use App\User;
use Log;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class FakeFailedTask implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    protected $type;

    /**
     * Create a new job instance.
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
        Log::info("FakeFailedTask: {$this->type}");

        Log::info($this->user->toArray());

        throw new Exception("伪造处理失败的任务", 1);
    }

    /**
     * 任务处理失败时处理: 例如发送短信提醒开发者 提醒用户之类的
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        Log::error('FakeFailedTask -- 任务处理失败 --' . $exception->getMessage());
    }
}
