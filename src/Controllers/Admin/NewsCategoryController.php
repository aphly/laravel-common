<?php

namespace Aphly\LaravelCommon\Controllers\Admin;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\Breadcrumb;
use Aphly\LaravelCommon\Models\NewsCategory;
use Illuminate\Http\Request;

class NewsCategoryController extends Controller
{
    public $index_url='/common_admin/news_category/index';

    private $currArr = ['name'=>'新闻分类','key'=>'news_category'];

    public function index(Request $request)
    {
        $res['search']['name'] = $request->query('name','');
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = NewsCategory::when($res['search'],
            function($query,$search) {
                if($search['name']!==''){
                    $query->where('name', 'like', '%'.$search['name'].'%');
                }
            })
            ->orderBy('sort','desc')
            ->Paginate(config('admin.perPage'))->withQueryString();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url]
        ]);
        return $this->makeView('laravel-common::admin.news_category.index',['res'=>$res]);
    }

	public function add(Request $request)
	{
		if($request->isMethod('post')) {
			$post = $request->all();
			$res['info'] = NewsCategory::create($post);
			$form_edit = $request->input('form_edit',0);
			if($res['info']->id){
				throw new ApiException(['code'=>0,'msg'=>'添加成功','data'=>['redirect'=>$form_edit?$this->index_url:'/common_admin/news_category/tree']]);
			}else{
				throw new ApiException(['code'=>1,'msg'=>'添加失败','data'=>[]]);
			}
		}else{
			$res['info'] = NewsCategory::where('id',$request->query('id',0))->firstOrNew();
            $res['breadcrumb'] = Breadcrumb::render([
                ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
                ['name'=>'新增','href'=>'/common_admin/category/add']
            ]);
			return $this->makeView('laravel-common::admin.news_category.form',['res'=>$res]);
		}
	}

	public function edit(Request $request)
	{
		$res['info'] = NewsCategory::where('id',$request->query('id',0))->firstOrError();
		if($request->isMethod('post')) {
			$post = $request->all();
			$form_edit = $request->input('form_edit',0);
			if($res['info']->update($post)){
				throw new ApiException(['code'=>0,'msg'=>'修改成功','data'=>['redirect'=>$form_edit?$this->index_url:'/common_admin/news_category/tree']]);
			}else{
				throw new ApiException(['code'=>1,'msg'=>'修改失败','data'=>[]]);
			}
		}else{
            $res['breadcrumb'] = Breadcrumb::render([
                ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
                ['name'=>'编辑','href'=>'/common_admin/category/edit?id='.$res['info']->id]
            ]);
			return $this->makeView('laravel-common::admin.news_category.form',['res'=>$res]);
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

    public function tree()
    {
        $res['list'] = NewsCategory::orderBy('sort', 'desc')->get()->keyBy('id')->toArray();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
            ['name'=>'树','href'=>'/common_admin/news_category/tree']
        ]);
        return $this->makeView('laravel-common::admin.news_category.tree',['res'=>$res]);
    }

    public function save(Request $request){
        $id = $request->query('id',0);
        $form_edit = $request->input('form_edit',0);
        if($form_edit && $id){
            NewsCategory::updateOrCreate(['id'=>$id],$request->all());
        }else{
            NewsCategory::updateOrCreate(['id'=>$id,'pid'=>$request->input('pid',0)],$request->all());
            $this->index_url = '/common_admin/news_category/tree';
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
