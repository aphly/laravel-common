<?php

namespace Aphly\LaravelCommon\Controllers\Front;

use Illuminate\Http\Request;

class NotfoundController extends Controller
{
    function index(Request $request){
        $res['title'] = '404';
        return $this->makeView('laravel-common-front::common.notfound',['res'=>$res]);
    }

}
