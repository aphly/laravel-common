<?php

namespace Aphly\LaravelCommon\Middleware;

use Aphly\Laravel\Exceptions\ApiException;
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
                return $this->_redirect($request,url(''));
            }else{
                return $next($request);
            }
        }else{
            if ($auth->check()) {
                if($auth->user()->status==2){
                    return $this->_redirect($request,route('blocked'));
                }else{
                    return $next($request);
                }
            }else{
                return $this->_redirect($request,route('login'));
            }
        }
    }

    function _redirect($request,$url){
        if($request->ajax()){
            throw new ApiException(['code'=>1,'msg'=>'redirect','data'=>['redirect'=>$url]]);
        }else{
            return redirect($url);
        }
    }

}
