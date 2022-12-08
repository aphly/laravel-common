<?php

namespace Aphly\LaravelCommon\Controllers\Front;

use Aphly\LaravelAdmin\Models\Config;
use Aphly\LaravelCommon\Models\Currency;
use Aphly\LaravelCommon\Models\Links;
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
                View::share("id",$this->user->initId());
                View::share("user",$this->user);
                View::share("checkin",(new UserCheckin)->getByUuid($this->user->uuid));
            }else{
                View::share("user",[]);
                View::share("checkin",[]);
            }
            View::share("links",(new Links)->menu());
            $currency = (new Currency)->defaultCurr();
            if(isset($currency[2]) && !empty($currency[2]['timezone'])){
                date_default_timezone_set($currency[2]['timezone']);
            }
            View::share("currency",$currency);
            $this->afterController();
            return $next($request);
        });
        parent::__construct();
    }

    public function afterController()
    {
        $class = ['\Aphly\LaravelShop\Controllers\Front\Controller'];
        foreach ($class as $val) {
            if (class_exists($val)) {
                (new $val)->afterController($this);
            }
        }
    }
}
