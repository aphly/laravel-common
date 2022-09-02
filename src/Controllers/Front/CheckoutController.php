<?php

namespace Aphly\LaravelCommon\Controllers\Front;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelPayment\Models\Payment;
use Illuminate\Http\Request;


class CheckoutController extends Controller
{

    public function success(Request $request)
    {
        $res['title'] = 'checkout Success';
        $res['payment'] = Payment::where('id',$request->query('payment_id',0))->first();
        return $this->makeView('laravel-common::front.checkout.success',['res'=>$res]);
    }

    public function fail(Request $request)
    {
        $res['title'] = 'checkout Fail';
        $res['payment'] = Payment::where('id',$request->query('payment_id',0))->first();
        return $this->makeView('laravel-common::front.checkout.fail',['res'=>$res]);
    }

}
