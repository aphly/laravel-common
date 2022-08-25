<?php

namespace Aphly\LaravelCommon\Controllers\Admin;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelCommon\Models\Country;
use Aphly\LaravelCommon\Models\Zone;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    public $index_url='/common_admin/zone/index';

    public function index(Request $request)
    {
        $res['search']['name'] = $name = $request->query('name',false);
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = Zone::when($name,
                function($query,$name) {
                    return $query->where('name', 'like', '%'.$name.'%');
                })
            ->orderBy('id','desc')
            ->Paginate(config('admin.perPage'))->withQueryString();
        $res['country'] = Country::get()->keyBy('id')->toArray();
        return $this->makeView('laravel-common::admin.zone.index',['res'=>$res]);
    }

    public function form(Request $request)
    {
        $res['info'] = Zone::where('id',$request->query('id',0))->firstOrNew();
        $res['country'] = Country::get()->keyBy('id')->toArray();
        return $this->makeView('laravel-common::admin.zone.form',['res'=>$res]);
    }

    public function save(Request $request){
        Zone::updateOrCreate(['id'=>$request->query('id',0)],$request->all());
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            Zone::whereIn('id',$post)->delete();
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }

}
