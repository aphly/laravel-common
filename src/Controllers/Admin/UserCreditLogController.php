<?php

namespace Aphly\LaravelCommon\Controllers\Admin;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\Breadcrumb;
use Aphly\LaravelCommon\Models\UserCredit;
use Aphly\LaravelCommon\Models\UserCreditLog;
use Illuminate\Http\Request;

class UserCreditLogController extends Controller
{
    public $index_url='/common_admin/user_credit_log/index';

    private $currArr = ['name'=>'积分记录','key'=>'user_credit_log'];

    public function index(Request $request)
    {
        $res['search']['name'] = $request->query('name',false);
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = UserCreditLog::when($res['search']['name'],
                function($query,$name) {
                    return $query->where('name', 'like', '%'.$name.'%');
                })
            ->orderBy('id','desc')
            ->Paginate(config('admin.perPage'))->withQueryString();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'],'href'=>$this->index_url]
        ]);
        return $this->makeView('laravel-common::admin.user_credit_log.index',['res'=>$res]);
    }

    public function form(Request $request)
    {
        $res['info'] = UserCreditLog::where('id',$request->query('id',0))->firstOrNew();
        $res['credit_key'] = UserCredit::CreditKey;
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'],'href'=>$this->index_url],
            ['name'=>$res['info']->id?'编辑':'新增','href'=>'/common_admin/'.$this->currArr['key'].($res['info']->id?'/form?id='.$res['info']->id:'/form')]
        ]);
        return $this->makeView('laravel-common::admin.user_credit_log.form',['res'=>$res]);
    }

    public function save(Request $request){
        UserCreditLog::updateOrCreate(['id'=>$request->query('id',0)],$request->all());
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            UserCreditLog::whereIn('id',$post)->delete();
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }

}
