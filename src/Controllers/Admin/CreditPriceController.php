<?php

namespace Aphly\LaravelCommon\Controllers\Admin;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelCommon\Models\CreditPrice;
use Aphly\LaravelCommon\Models\UserCredit;
use Illuminate\Http\Request;

class CreditPriceController extends Controller
{
    public $index_url='/common_admin/credit_price/index';

    public function index(Request $request)
    {
        $res['search']['credit_key'] = $credit_key = $request->query('credit_key',false);
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = CreditPrice::when($credit_key,
                function($query,$credit_key) {
                    return $query->where('credit_key',$credit_key);
                })
            ->orderBy('id','desc')
            ->Paginate(config('admin.perPage'))->withQueryString();
        $res['credit_key'] = UserCredit::CreditKey;
        return $this->makeView('laravel-common::admin.credit_price.index',['res'=>$res]);
    }

    public function form(Request $request)
    {
        $res['info'] = CreditPrice::where('id',$request->query('id',0))->firstOrNew();
        $res['credit_key'] = UserCredit::CreditKey;
        return $this->makeView('laravel-common::admin.credit_price.form',['res'=>$res]);
    }

    public function save(Request $request){
        CreditPrice::updateOrCreate(['id'=>$request->query('id',0)],$request->all());
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            CreditPrice::whereIn('id',$post)->delete();
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }

}
