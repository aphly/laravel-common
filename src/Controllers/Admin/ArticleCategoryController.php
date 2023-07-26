<?php

namespace Aphly\LaravelCommon\Controllers\Admin;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\Breadcrumb;
use Aphly\LaravelCommon\Models\ArticleCategory;
use Aphly\LaravelCommon\Models\ArticleCategoryPath;
use Illuminate\Http\Request;

class ArticleCategoryController extends Controller
{
    public $index_url='/common_admin/article_category/index';

    private $currArr = ['name'=>'文章分类','key'=>'article_category'];

    public function index(Request $request)
    {
        $res['search']['name'] = $request->query('name','');
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = ArticleCategory::when($res['search'],
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
        return $this->makeView('laravel-common::admin.article_category.index',['res'=>$res]);
    }

    public function rebuild()
    {
        (new ArticleCategoryPath)->rebuild();
        throw new ApiException(['code'=>0,'msg'=>'操作成功']);
    }

	public function add(Request $request)
	{
		if($request->isMethod('post')) {
			$post = $request->all();
			$res['info'] = ArticleCategory::create($post);
			$form_edit = $request->input('form_edit',0);
			if($res['info']->id){
                (new ArticleCategoryPath)->add($res['info']->id,$res['info']->pid);
				throw new ApiException(['code'=>0,'msg'=>'添加成功','data'=>['redirect'=>$form_edit?$this->index_url:'/common_admin/article_category/tree']]);
			}else{
				throw new ApiException(['code'=>1,'msg'=>'添加失败','data'=>[]]);
			}
		}else{
			$res['info'] = ArticleCategory::where('id',$request->query('id',0))->firstOrNew();
            $res['breadcrumb'] = Breadcrumb::render([
                ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
                ['name'=>'新增','href'=>'/common_admin/category/add']
            ]);
			return $this->makeView('laravel-common::admin.article_category.form',['res'=>$res]);
		}
	}

	public function edit(Request $request)
	{
		$res['info'] = ArticleCategory::where('id',$request->query('id',0))->firstOrError();
		if($request->isMethod('post')) {
			$post = $request->all();
			$form_edit = $request->input('form_edit',0);
			if($res['info']->update($post)){
				throw new ApiException(['code'=>0,'msg'=>'修改成功','data'=>['redirect'=>$form_edit?$this->index_url:'/common_admin/article_category/tree']]);
			}else{
				throw new ApiException(['code'=>1,'msg'=>'修改失败','data'=>[]]);
			}
		}else{
            $res['breadcrumb'] = Breadcrumb::render([
                ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
                ['name'=>'编辑','href'=>'/common_admin/category/edit?id='.$res['info']->id]
            ]);
			return $this->makeView('laravel-common::admin.article_category.form',['res'=>$res]);
		}
	}

    public function form(Request $request)
    {
        $res['info'] = ArticleCategory::where('id',$request->query('id',0))->firstOrNew();
        if(!empty($res['info']) && $res['info']->pid){
            $res['parent_info'] = ArticleCategory::where('id',$res['info']->pid)->first();
        }
        return $this->makeView('laravel-common::admin.article_category.form',['res'=>$res]);
    }

    public function tree()
    {
        $res['list'] = ArticleCategory::orderBy('sort', 'desc')->get()->keyBy('id')->toArray();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
            ['name'=>'树','href'=>'/common_admin/article_category/tree']
        ]);
        return $this->makeView('laravel-common::admin.article_category.tree',['res'=>$res]);
    }

    public function save(Request $request){
        $id = $request->query('id',0);
        $form_edit = $request->input('form_edit',0);
        if($form_edit && $id){
            $category = ArticleCategory::updateOrCreate(['id'=>$id],$request->all());
            (new ArticleCategoryPath)->add($category->id,$category->pid);
        }else{
            ArticleCategory::updateOrCreate(['id'=>$id,'pid'=>$request->input('pid',0)],$request->all());
            $this->index_url = '/common_admin/article_category/tree';
        }
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            $data = ArticleCategory::where('pid',$post)->get();
            if($data->isEmpty()){
                ArticleCategory::destroy($post);
                throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
            }else{
                throw new ApiException(['code'=>1,'msg'=>'请先删除子分类']);
            }
        }
    }


}
