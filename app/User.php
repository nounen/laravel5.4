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

    /**
     * 获取器: 字段未必存在
     *
     * 获取用户的名字。
     */
    public function getFirstNameAttribute()
    {
        return ucfirst($this->name);
    }

    /**
     * 修改器: 字段必须存在, 否则 save 时会报错
     *
     * 设定用户的名字。
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value . '-setter');
    }
}
