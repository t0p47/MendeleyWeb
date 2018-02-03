<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;


class DeniedIfNotLogin
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
		//если администратор не залогинен guard не admin_user(смотри в параметре функции)
		
		$guard = 'admin_user';
		
		//Не админ
		if(!Auth::guard($guard)->check()){
			
			$guard = 'web';
			//Не пользователь
			if(!Auth::guard($guard)->check()){
				//abort(403);
				return response("Access denied nobody logged in",403);
				
			//Пользователь	
			}else{
				return $next($request);
			}
		//Админ
		}else{
			return $next($request);
		}
        
    }
}
