<?php

namespace Aphly\LaravelCommon\Controllers\Front;

use Aphly\LaravelAdmin\Models\Config;
use Aphly\LaravelCommon\Models\Currency;
use Aphly\LaravelCommon\Models\Links;
use Aphly\LaravelCommon\Models\Template;
use Aphly\LaravelCommon\Models\UserCheckin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
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
            View::share("links",(new Links)->menu());
            View::share("currency",(new Currency)->defaultCurr());
            return $next($request);
        });
        parent::__construct();
    }


}
