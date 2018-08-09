<?php

namespace App\Http\Middleware;

use Closure;
use Route,URL,Auth;

class Permission
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
        $user = Auth::user();
        if($user->id === 1){
            return $next($request);
        }

        $active_url = Route::currentRouteName();

        if ($user->can($active_url)){
            return $next($request);
        }
        abort('401');
    }
}
