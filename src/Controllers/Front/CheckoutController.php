<?php

namespace Aphly\LaravelCommon\Controllers\Front;

use Aphly\Laravel\Exceptions\ApiException;
use Illuminate\Http\Request;


class CheckoutController extends Controller
{

    public function success(Request $request)
    {
        $res['title'] = 'checkout Success';
        return $this->makeView('laravel-common::front.checkout.success',['res'=>$res]);
    }

    public function fail(Request $request)
    {
        $res['title'] = 'checkout Fail';
        return $this->makeView('laravel-common::front.checkout.fail',['res'=>$res]);
    }

}
