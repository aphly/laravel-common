<?php

namespace Aphly\LaravelCommon\Controllers\Admin;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelCommon\Models\NewsCategory;
use Illuminate\Http\Request;

class NewsCategoryController extends Controller
{
    public $index_url='/common_admin/news_category/index';

    public function index(Request $request)
    {
        $res['search']['name'] = $name = $request->query('name',false);
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = NewsCategory::when($name,
                function($query,$name) {
                    return $query->where('name', 'like', '%'.$name.'%');
                })
            ->orderBy('sort','desc')
            ->Paginate(config('admin.perPage'))->withQueryString();
        //$res['fast_save'] = Category::where('status',1)->orderBy('sort', 'desc')->get()->toArray();
        return $this->makeView('laravel-common::admin.news_category.index',['res'=>$res]);
    }

    public function show()
    {
        $data = NewsCategory::orderBy('sort', 'desc')->get();
        $res['list'] = $data->toArray();
        $res['listById'] = $data->keyBy('id')->toArray();
        return $this->makeView('laravel-common::admin.news_category.show',['res'=>$res]);
    }

    public function save(Request $request){
        $id = $request->query('id',0);
        NewsCategory::updateOrCreate(['id'=>$id,'pid'=>$request->input('pid',0),],$request->all());
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>'/common_admin/news_category/show']]);
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            $data = NewsCategory::where('pid',$post)->get();
            if($data->isEmpty()){
                NewsCategory::destroy($post);
                throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
            }else{
                throw new ApiException(['code'=>1,'msg'=>'请先删除子分类','data'=>['redirect'=>$redirect]]);
            }
        }
    }


}
