<?php

namespace Aphly\LaravelCommon\Controllers\Front;

use Aphly\LaravelAdmin\Models\Config;
use Aphly\LaravelCommon\Models\Link;
use Aphly\LaravelCommon\Models\UserCheckin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class Controller extends \Aphly\Laravel\Controllers\Controller
{
    public $user = null;
    public $config = null;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $auth = Auth::guard('user');
            $this->config = (new Config)->getByType();
            View::share("config",$this->config);
            if($auth->check()){
                $this->user = $auth->user();
                View::share("user",$this->user);
                View::share("checkin",(new UserCheckin)->getByUuid($this->user->uuid));
            }else{
                View::share("user",[]);
                View::share("checkin",[]);
            }
            View::share("link",(new Link)->menu());
            return $next($request);
        });
        parent::__construct();
    }
}
