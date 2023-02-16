<?php

namespace Aphly\LaravelCommon\Controllers\Front;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelPayment\Models\Payment;
use Illuminate\Http\Request;


class CheckoutController extends Controller
{

    public function success(Request $request)
    {
        $res['title'] = 'Checkout Success';
        //$res['payment'] = Payment::where('id',$request->query('payment_id',0))->first();
        $res['redirect'] = $request->query('redirect','');
        if($res['redirect']){
            $res['redirect']= urldecode($res['redirect']);
        }
        return $this->makeView('laravel-common-front::checkout.success',['res'=>$res]);
    }

    public function fail(Request $request)
    {
        $res['title'] = 'Checkout Fail';
        //$res['payment'] = Payment::where('id',$request->query('payment_id',0))->first();
        $res['redirect'] = $request->query('redirect','');
        if($res['redirect']){
            $res['redirect']= urldecode($res['redirect']);
        }
        return $this->makeView('laravel-common-front::checkout.fail',['res'=>$res]);
    }

}
