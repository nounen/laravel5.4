<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;

    // 一旦数据被设置为公共属性，它们将自动在视图中加载
    public $user;

    protected $pUser;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;

        $this->pUser = $user;
    }

    /**
     * Build the message. 配置发送者
     *
     * @return $this
     */
    public function build()
    {
        // 没有设置 from 就会默认使用全局的 from 地址: 在config/mail.php
        // return $this->from('example@example.com')
        //             ->view('emails.orders.shipped');

        return $this->view('emails.orders.shipped')
                    ->with([
                        'name' => $this->pUser->name
                    ]);
                    // ->attach('/storage/logs/laravel-2017-08-06.log');
    }
}
