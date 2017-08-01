<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['name'];

    /**
     * 获取拥有此任务的用户。
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
