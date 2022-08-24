<?php

namespace Aphly\LaravelCommon\Controllers\Front;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelCommon\Models\News;
use Illuminate\Http\Request;


class NewsController extends Controller
{

    function info(Request $request){
        $res['info'] = (new News())->show($request->id);
        $res['info'] = $res['info']->toArray();
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>'','res'=>$res]]);
    }

}
