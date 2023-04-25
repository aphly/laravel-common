<?php

namespace Aphly\LaravelCommon\Controllers\Admin;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\Breadcrumb;
use Aphly\LaravelCommon\Models\Category;
use Aphly\LaravelCommon\Models\CategoryPath;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public $index_url='/common_admin/category/index';

    private $currArr = ['name'=>'分类','key'=>'category'];

    public function index(Request $request)
    {
        $res['search']['name'] = $request->query('name',false);
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = CategoryPath::leftJoin('common_category as c1','c1.id','=','common_category_path.category_id')
            ->leftJoin('common_category as c2','c2.id','=','common_category_path.path_id')
            ->when($res['search']['name'],
                function($query,$name) {
                    return $query->where('c1.name', 'like', '%'.$name.'%');
                })
            ->groupBy('category_id')
            ->selectRaw('any_value(c1.`id`) AS id,any_value(common_category_path.`category_id`) AS category_id,
                GROUP_CONCAT(c2.`name` ORDER BY common_category_path.level SEPARATOR \'&nbsp;&nbsp;&gt;&nbsp;&nbsp;\') AS name,
                any_value(c1.`status`) AS status,
                any_value(c1.`sort`) AS sort')
            ->orderBy('c1.sort','desc')
            ->Paginate(config('admin.perPage'))->withQueryString();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url]
        ]);
        return $this->makeView('laravel-common::admin.category.index',['res'=>$res]);
    }

    public function form(Request $request)
    {
        $res['info'] = Category::where('id',$request->query('id',0))->firstOrNew();
        if(!empty($res['info']) && $res['info']->pid){
            $res['parent_info'] = Category::where('id',$res['info']->pid)->first();
        }
        return $this->makeView('laravel-common::admin.category.form',['res'=>$res]);
    }

    public function tree()
    {
        $res['list'] = Category::orderBy('sort', 'desc')->get()->keyBy('id')->toArray();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
            ['name'=>'树','href'=>'/common_admin/category/tree']
        ]);
        return $this->makeView('laravel-common::admin.category.tree',['res'=>$res]);
    }

    public function save(Request $request){
        $id = $request->query('id',0);
        $form_edit = $request->input('form_edit',0);
        if($form_edit && $id){
            Category::updateOrCreate(['id'=>$id],$request->all());
        }else{
            $category = Category::updateOrCreate(['id'=>$id,'pid'=>$request->input('pid',0)],$request->all());
            (new CategoryPath)->add($category->id,$category->pid);
            $this->index_url = '/common_admin/category/tree';
        }
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
    }

	public function add(Request $request)
	{
		if($request->isMethod('post')) {
			$post = $request->all();
			$res['info'] = Category::create($post);
			$form_edit = $request->input('form_edit',0);
			if($res['info']->id){
				(new CategoryPath)->add($res['info']->id,$res['info']->pid);
				throw new ApiException(['code'=>0,'msg'=>'添加成功','data'=>['redirect'=>$form_edit?$this->index_url:'/common_admin/category/tree']]);
			}else{
				throw new ApiException(['code'=>1,'msg'=>'添加失败','data'=>[]]);
			}
		}else{
			$res['info'] = Category::where('id',$request->query('id',0))->firstOrNew();
            $res['breadcrumb'] = Breadcrumb::render([
                ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
                ['name'=>'新增','href'=>'/common_admin/category/add']
            ]);
			return $this->makeView('laravel-common::admin.category.form',['res'=>$res]);
		}
	}

	public function edit(Request $request)
	{
		$res['info'] = Category::where('id',$request->query('id',0))->firstOrError();
		if($request->isMethod('post')) {
			$post = $request->all();
			$form_edit = $request->input('form_edit',0);
			if($res['info']->update($post)){
				throw new ApiException(['code'=>0,'msg'=>'修改成功','data'=>['redirect'=>$form_edit?$this->index_url:'/common_admin/category/tree']]);
			}else{
				throw new ApiException(['code'=>1,'msg'=>'修改失败','data'=>[]]);
			}
		}else{
            $res['breadcrumb'] = Breadcrumb::render([
                ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
                ['name'=>'编辑','href'=>'/common_admin/category/edit?id='.$res['info']->id]
            ]);
			return $this->makeView('laravel-common::admin.category.form',['res'=>$res]);
		}
	}

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            $data = Category::where('pid',$post)->get();
            if($data->isEmpty()){
                Category::destroy($post);
                CategoryPath::whereIn('category_id',$post)->delete();
                throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
            }else{
                throw new ApiException(['code'=>1,'msg'=>'请先删除子分类']);
            }
        }
    }

    public function ajax(Request $request){
        $name = $request->query('name',false);
        $list = CategoryPath::leftJoin('common_category as c1','c1.id','=','common_category_path.category_id')
            ->leftJoin('common_category as c2','c2.id','=','common_category_path.path_id')
            ->when($name,
                function($query,$name) {
                    return $query->where('c1.name', 'like', '%'.$name.'%');
                })
            ->where('c1.status', 1)
            ->groupBy('category_id')
            ->selectRaw('any_value(c1.`id`) AS id,any_value(common_category_path.`category_id`) AS category_id,
                GROUP_CONCAT(c2.`name` ORDER BY common_category_path.level SEPARATOR \'&nbsp;&nbsp;&gt;&nbsp;&nbsp;\') AS name,
                any_value(c1.`status`) AS status,
                any_value(c1.`sort`) AS sort')
            ->get()->toArray();
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['list'=>$list]]);
    }

}
