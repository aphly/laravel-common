<?php

namespace Aphly\LaravelCommon\Controllers\Admin;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelCommon\Models\Category;
use Aphly\LaravelCommon\Models\CategoryPath;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public $index_url='/common_admin/category/index';

    public function index(Request $request)
    {
        $res['filter']['name'] = $name = $request->query('name',false);
        $res['filter']['string'] = http_build_query($request->query());
        $res['list'] = CategoryPath::leftJoin('common_category as c1','c1.id','=','common_category_path.category_id')
            ->leftJoin('common_category as c2','c2.id','=','common_category_path.path_id')
            ->when($name,
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
        //$res['fast_save'] = Category::where('status',1)->orderBy('sort', 'desc')->get()->toArray();
        return $this->makeView('laravel-common::admin.category.index',['res'=>$res]);
    }

    public function show()
    {
        $data = Category::orderBy('sort', 'desc')->get();
        $res['list'] = $data->toArray();
        $res['listById'] = $data->keyBy('id')->toArray();
        return $this->makeView('laravel-common::admin.category.show',['res'=>$res]);
    }

    public function save(Request $request){
        $id = $request->query('id',0);
        $category = Category::updateOrCreate(['id'=>$id,'pid'=>$request->input('pid',0),],$request->all());
        (new CategoryPath)->add($category->id,$category->pid);
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>'/common_admin/category/show']]);
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
                throw new ApiException(['code'=>1,'msg'=>'请先删除目录内的菜单','data'=>['redirect'=>$redirect]]);
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
