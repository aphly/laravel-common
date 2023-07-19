<?php

namespace Aphly\LaravelCommon\Controllers\Admin;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\Breadcrumb;
use Aphly\LaravelCommon\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public $index_url='/common_admin/country/index';

    private $currArr = ['name'=>'国家','key'=>'country'];

    public function index(Request $request)
    {
        $res['search']['name'] = $request->query('name','');
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = Country::when($res['search'],
                function($query,$search) {
                    if($search['name']!==''){
                        $query->where('name', 'like', '%'.$search['name'].'%');
                    }
                })
            ->orderBy('id','desc')
            ->Paginate(config('admin.perPage'))->withQueryString();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url]
        ]);
        return $this->makeView('laravel-common::admin.country.index',['res'=>$res]);
    }

    public function form(Request $request)
    {
        $res['info'] = Country::where('id',$request->query('id',0))->firstOrNew();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
            ['name'=>$res['info']->id?'编辑':'新增','href'=>'/common_admin/'.$this->currArr['key'].($res['info']->id?'/form?id='.$res['info']->id:'/form')]
        ]);
        return $this->makeView('laravel-common::admin.country.form',['res'=>$res]);
    }

    public function save(Request $request){
        Country::updateOrCreate(['id'=>$request->query('id',0)],$request->all());
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            Country::whereIn('id',$post)->delete();
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }

}
