<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

/**
 * [AuthenticateOnceWithBasicAuth 无状态 HTTP 基础认证]
 *
 * http://d.laravel-china.org/docs/5.4/authentication#无状态-HTTP-基础认证
 */
class AuthenticateOnceWithBasicAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return Auth::onceBasic() ?: $next($request);
    }
}
