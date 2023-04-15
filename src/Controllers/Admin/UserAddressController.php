<?php

namespace Aphly\LaravelCommon\Controllers\Admin;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelCommon\Models\UserAddress;
use Aphly\LaravelCommon\Models\Country;
use Aphly\LaravelCommon\Models\Zone;
use Illuminate\Http\Request;

class UserAddressController extends Controller
{
    public $index_url='/common_admin/user_address/index';

    public function index(Request $request)
    {
        $res['search']['uuid'] = $request->query('uuid',false);
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = UserAddress::when($res['search']['uuid'],
            function($query,$uuid) {
                return $query->where('uuid', $uuid);
            })
            ->orderBy('id','desc')
            ->Paginate(config('admin.perPage'))->withQueryString();
        return $this->makeView('laravel-common::admin.user_address.index',['res'=>$res]);
    }

    public function form(Request $request)
    {
        $res['info'] = UserAddress::where('id',$request->query('id',0))->firstOrNew();
        $res['country'] = (new Country)->findAll();
        //$country_keys = array_keys($res['country']);
        if($res['info']->id){
            $res['zone'] = (new Zone)->findAllByCountry($res['info']->country_id);
        }else{
            $res['zone'] = [];
        }
        return $this->makeView('laravel-common::admin.user_address.form',['res'=>$res]);
    }

    public function save(Request $request){
        UserAddress::updateOrCreate(['id'=>$request->query('id',0)],$request->all());
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            UserAddress::whereIn('id',$post)->delete();
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }

}
