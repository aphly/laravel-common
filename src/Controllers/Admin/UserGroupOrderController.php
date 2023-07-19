<?php

namespace Aphly\LaravelCommon\Controllers\Admin;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\Breadcrumb;
use Aphly\LaravelCommon\Models\Group;
use Aphly\LaravelCommon\Models\UserGroupOrder;
use Illuminate\Http\Request;

class UserGroupOrderController extends Controller
{
    public $index_url='/common_admin/user_group_order/index';

    private $currArr = ['name'=>'用户组订单','key'=>'user_group_order'];

    public function index(Request $request)
    {
        $res['search']['uuid'] = $request->query('uuid','');
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = UserGroupOrder::when($res['search'],
                function($query,$search) {
                    if($search['uuid']!==''){
                        $query->where('uuid', $search['uuid']);
                    }
                })
            ->orderBy('id','desc')
            ->Paginate(config('admin.perPage'))->withQueryString();
        $res['group'] = Group::get()->keyBy('id');
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url]
        ]);
        return $this->makeView('laravel-common::admin.user_group_order.index',['res'=>$res]);
    }

    public function form(Request $request)
    {
        $res['info'] = UserGroupOrder::where('id',$request->query('id',0))->firstOrNew();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
            ['name'=>$res['info']->id?'编辑':'新增','href'=>'/common_admin/'.$this->currArr['key'].($res['info']->id?'/form?id='.$res['info']->id:'/form')]
        ]);
        return $this->makeView('laravel-common::admin.user_group_order.form',['res'=>$res]);
    }

    public function save(Request $request){
        $res['info'] = UserGroupOrder::where('id',$request->query('id',0))->firstOrError();
        if($res['info']->status==1 && $request->input('status',0)==2){
            $res['info']->notify();
        }
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
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
