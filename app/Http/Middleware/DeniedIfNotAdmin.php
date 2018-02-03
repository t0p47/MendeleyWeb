<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;


class DeniedIfNotAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'admin_user')
    {
		//если администратор не залогинен guard не admin_user(смотри в параметре функции)
		if(!Auth::guard($guard)->check()){
			//abort(403);
			return response("Access denied",403);
		}
        return $next($request);
    }
}
