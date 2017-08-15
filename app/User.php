<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Scopes\TestGlobalScope;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected static function boot()
    {
        parent::boot();

        // 应用全局作用域
        static::addGlobalScope(new TestGlobalScope);
    }

    /**
     * 获取该用户的所有任务。
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function isSuperAdmin()
    {
        return true;
    }
}
