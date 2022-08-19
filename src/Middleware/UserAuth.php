<?php

namespace Aphly\LaravelCommon\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Closure;

class UserAuth
{
    public function handle(Request $request, Closure $next)
    {
        $auth = Auth::guard('user');
        if($request->url()==route('login') || $request->url()==route('register')){
            if ($auth->check()) {
                return redirect('/');
            }else{
                return $next($request);
            }
        }else{
            if ($auth->check()) {
                if($auth->user()->status==2){
                    return redirect(route('blocked'));
                }else{
                    return $next($request);
                }
            }else{
                return redirect(route('login'));
            }
        }
    }

}
