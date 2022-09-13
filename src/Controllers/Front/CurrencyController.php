<?php

namespace Aphly\LaravelCommon\Controllers\Front;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelCommon\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CurrencyController extends Controller
{

    public function ajax(Request $request)
    {
        $res['info'] = Currency::where('id',$request->id)->first();
        if(!empty($res['info']) && $res['info']->status==1){
            Cookie::queue('currency',$res['info']->code);
            throw new ApiException(['code'=>0,'msg'=>'success']);
        }
    }


}
