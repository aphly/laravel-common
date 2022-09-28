<?php

namespace Aphly\LaravelCommon\Controllers\Front;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelCommon\Models\Zone;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function zone(Request $request){
        $list = (new Zone)->findAllByCountry($request->id);
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>$list]);
    }

    public function test(Request $request){
        $list = Zone::Paginate(config('admin.perPage'))->withQueryString();
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['list'=>$list]]);
    }


}
