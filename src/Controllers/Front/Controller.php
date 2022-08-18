<?php

namespace Aphly\LaravelUser\Controllers\Front;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class Controller extends \Aphly\Laravel\Controllers\Controller
{
    public $user = null;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $auth = Auth::guard('user');
            if($auth->check()){
                $this->user = $auth->user();
                View::share("user",$this->user);
            }else{
                View::share("user",[]);
            }
            return $next($request);
        });
        parent::__construct();
    }
}
