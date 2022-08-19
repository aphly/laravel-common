<?php

namespace Aphly\LaravelCommon\Controllers\Admin;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelCommon\Models\UserCredit;
use Aphly\LaravelCommon\Models\UserCreditOrder;
use Illuminate\Http\Request;

class UserCreditOrderController extends Controller
{
    public $index_url='/common_admin/user_credit_order/index';

    public function index(Request $request)
    {
        $res['filter']['name'] = $name = $request->query('name',false);
        $res['filter']['string'] = http_build_query($request->query());
        $res['list'] = UserCreditOrder::when($name,
                function($query,$name) {
                    return $query->where('name', 'like', '%'.$name.'%');
                })
            ->orderBy('id','desc')
            ->Paginate(config('admin.perPage'))->withQueryString();
        return $this->makeView('laravel-common::admin.user_credit_order.index',['res'=>$res]);
    }

    public function form(Request $request)
    {
        $res['info'] = UserCreditOrder::where('id',$request->query('id',0))->firstOrNew();
        $res['credit_key'] = UserCredit::CreditKey;
        return $this->makeView('laravel-common::admin.user_credit_order.form',['res'=>$res]);
    }

    public function save(Request $request){
        UserCreditOrder::updateOrCreate(['id'=>$request->query('id',0)],$request->all());
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            UserCreditOrder::whereIn('id',$post)->delete();
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }

}
