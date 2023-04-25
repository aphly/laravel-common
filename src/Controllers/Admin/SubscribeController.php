<?php

namespace Aphly\LaravelCommon\Controllers\Admin;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\Breadcrumb;
use Aphly\LaravelCommon\Models\Subscribe;
use Illuminate\Http\Request;

class SubscribeController extends Controller
{
    public $index_url='/common_admin/subscribe/index';

    private $currArr = ['name'=>'订阅','key'=>'subscribe'];

    public function index(Request $request)
    {
        $res['search']['email'] = $request->query('email',false);
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = subscribe::when($res['search']['email'],
                function($query,$email) {
                    return $query->where('email', 'like', '%'.$email.'%');
                })
            ->orderBy('id','desc')
            ->Paginate(config('admin.perPage'))->withQueryString();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url]
        ]);
        return $this->makeView('laravel-common::admin.subscribe.index',['res'=>$res]);
    }

    public function form(Request $request)
    {
        $res['info'] = subscribe::where('id',$request->query('id',0))->firstOrNew();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
            ['name'=>$res['info']->id?'编辑':'新增','href'=>'/common_admin/'.$this->currArr['key'].($res['info']->id?'/form?id='.$res['info']->id:'/form')]
        ]);
        return $this->makeView('laravel-common::admin.subscribe.form',['res'=>$res]);
    }

    public function save(Request $request){
        $input = $request->all();
        subscribe::updateOrCreate(['id'=>$request->query('id',0)],$input);
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            subscribe::whereIn('id',$post)->delete();
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }

}
