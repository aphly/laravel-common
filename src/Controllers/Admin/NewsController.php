<?php

namespace Aphly\LaravelCommon\Controllers\Admin;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Libs\Editor;
use Aphly\LaravelCommon\Models\News;
use Aphly\LaravelCommon\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class NewsController extends Controller
{
    public $index_url = '/common_admin/news/index';

    public function index(Request $request)
    {
        $res['search']['title'] = $title = $request->query('title', false);
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = News::when($title,
                            function ($query, $title) {
                                return $query->where('title', 'like', '%' . $title . '%');
                            })
                        ->orderBy('id', 'desc')
                        ->Paginate(config('admin.perPage'))->withQueryString();
        return $this->makeView('laravel-common::admin.news.index', ['res' => $res]);
    }

    public function form(Request $request)
    {
        $res['info'] = News::where('id',$request->query('id',0))->firstOrNew();
        $res['newsCategory'] = NewsCategory::orderBy('sort','desc')->get()->toArray();
        if(count($res['newsCategory'])){
            $res['newsCategoryById'] = Arr::keyBy($res['newsCategory'], 'id');
        }else{
            $res['newsCategoryById'] = [];
        }
        if($res['info']->id){
            $res['select_ids'] = [$res['info']->news_category_id];
            $res['category_select_name'] = $res['newsCategoryById'][$res['info']->news_category_id]['name']??'';
        }else{
            $res['select_ids'] = [];
            $res['category_select_name'] = '';
        }
        return $this->makeView('laravel-common::admin.news.form',['res'=>$res]);
    }

    public function save(Request $request){
        $id = $request->query('id',0);
        $input = $request->all();
        $info = News::where('id',$id)->first();
        if(!empty($info)){
            $info->content = (new Editor)->edit($info->content,$request->input('content'));
            $info->save();
        }else{
            $input['content'] =  (new Editor)->add($request->input('content'));
            News::create($input);
        }
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            $data = News::whereIn('id',$post)->get();
            foreach($data as $val){
                (new Editor)->del($val->content);
            }
            News::whereIn('id',$post)->delete();
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }


}
