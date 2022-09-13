<?php

namespace Aphly\LaravelCommon\Controllers\Admin;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelCommon\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public $index_url='/common_admin/currency/index';

    public function index(Request $request)
    {
        $res['search']['name'] = $name = $request->query('name',false);
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = Currency::when($name,
                function($query,$name) {
                    return $query->where('name', 'like', '%'.$name.'%');
                })
            ->orderBy('id','desc')
            ->Paginate(config('admin.perPage'))->withQueryString();
        return $this->makeView('laravel-common::admin.currency.index',['res'=>$res]);
    }

    public function form(Request $request)
    {
        $res['info'] = Currency::where('id',$request->query('id',0))->firstOrNew();
        return $this->makeView('laravel-common::admin.currency.form',['res'=>$res]);
    }

    public function save(Request $request){
        $input = $request->all();
        if($input['default']==1){
          Currency::whereRaw('1')->update(['default'=>2]);
        }
        Currency::updateOrCreate(['id'=>$request->query('id',0)],$input);
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            Currency::whereIn('id',$post)->delete();
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }

}
