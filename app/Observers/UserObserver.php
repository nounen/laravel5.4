<?php

namespace App\Observers;

use App\User;
use Log;

class UserObserver
{
    /**
     * 监听用户创建的事件。
     *
     * @param  User  $user
     * @return void
     */
    public function updated(User $user)
    {
        Log::info('UserObserver updated');
    }

    /**
     * 监听用户删除事件。
     *
     * @param  User  $user
     * @return void
     */
    public function updating(User $user)
    {
        Log::info('UserObserver updating');
    }
}
