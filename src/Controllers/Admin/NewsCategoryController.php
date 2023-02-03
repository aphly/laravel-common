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

	public function add(Request $request)
	{
		if($request->isMethod('post')) {
			$post = $request->all();
			$res['info'] = NewsCategory::create($post);
			$form_edit = $request->input('form_edit',0);
			if($res['info']->id){
				throw new ApiException(['code'=>0,'msg'=>'添加成功','data'=>['redirect'=>$form_edit?$this->index_url($post):'/common_admin/news_category/show']]);
			}else{
				throw new ApiException(['code'=>1,'msg'=>'添加失败','data'=>[]]);
			}
		}else{
			$res['info'] = NewsCategory::where('id',$request->query('id',0))->firstOrNew();
			return $this->makeView('laravel-admin::news_category.form',['res'=>$res]);
		}
	}

	public function edit(Request $request)
	{
		$res['info'] = NewsCategory::where('id',$request->query('id',0))->firstOrError();
		if($request->isMethod('post')) {
			$post = $request->all();
			$form_edit = $request->input('form_edit',0);
			if($res['info']->update($post)){
				throw new ApiException(['code'=>0,'msg'=>'修改成功','data'=>['redirect'=>$form_edit?$this->index_url($post):'/common_admin/news_category/show']]);
			}else{
				throw new ApiException(['code'=>1,'msg'=>'修改失败','data'=>[]]);
			}
		}else{
			return $this->makeView('laravel-admin::news_category.form',['res'=>$res]);
		}
	}

    public function form(Request $request)
    {
        $res['info'] = NewsCategory::where('id',$request->query('id',0))->firstOrNew();
        if(!empty($res['info']) && $res['info']->pid){
            $res['parent_info'] = NewsCategory::where('id',$res['info']->pid)->first();
        }
        return $this->makeView('laravel-common::admin.news_category.form',['res'=>$res]);
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
        $form_edit = $request->input('form_edit',0);
        if($form_edit && $id){
            NewsCategory::updateOrCreate(['id'=>$id],$request->all());
        }else{
            NewsCategory::updateOrCreate(['id'=>$id,'pid'=>$request->input('pid',0)],$request->all());
            $this->index_url = '/common_admin/news_category/show';
        }
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
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
                throw new ApiException(['code'=>1,'msg'=>'请先删除子分类']);
            }
        }
    }


}
