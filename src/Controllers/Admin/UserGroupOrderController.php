<?php

namespace Aphly\LaravelCommon\Controllers\Admin;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelCommon\Models\Group;
use Aphly\LaravelCommon\Models\UserGroupOrder;
use Illuminate\Http\Request;

class UserGroupOrderController extends Controller
{
    public $index_url='/common_admin/user_group_order/index';

    public function index(Request $request)
    {
        $res['search']['uuid'] = $uuid = $request->query('uuid',false);
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = UserGroupOrder::when($uuid,
                function($query,$uuid) {
                    return $query->where('uuid',  $uuid);
                })
            ->orderBy('id','desc')
            ->Paginate(config('admin.perPage'))->withQueryString();
        $res['group'] = Group::get()->keyBy('id');
        return $this->makeView('laravel-common::admin.user_group_order.index',['res'=>$res]);
    }

    public function form(Request $request)
    {
        $res['info'] = UserGroupOrder::where('id',$request->query('id',0))->firstOrNew();
        return $this->makeView('laravel-common::admin.user_group_order.form',['res'=>$res]);
    }

    public function save(Request $request){
        $res['info'] = UserGroupOrder::where('id',$request->query('id',0))->first();
        if(!empty($res['info'])){
            if($res['info']->status==1 && $request->input('status',0)==2){
                $res['info']->notify();
            }
            throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
        }else{
            throw new ApiException(['code'=>1,'msg'=>'error']);
        }
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            UserGroupOrder::whereIn('id',$post)->delete();
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }

}
