<?php

namespace Aphly\LaravelCommon\Controllers\Admin;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelCommon\Models\Links;
use Illuminate\Http\Request;

class LinksController extends Controller
{
    public $index_url='/common_admin/links/index';

    public function index(Request $request)
    {
        $res['search']['name'] = $name = $request->query('name',false);
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = Links::when($name,
                function($query,$name) {
                    return $query->where('name', 'like', '%'.$name.'%');
                })
            ->orderBy('sort','desc')
            ->Paginate(config('admin.perPage'))->withQueryString();
        return $this->makeView('laravel-common::admin.links.index',['res'=>$res]);
    }

    public function show()
    {
        $data = Links::orderBy('sort', 'desc')->get();
        $res['list'] = $data->toArray();
        $res['listById'] = $data->keyBy('id')->toArray();
        return $this->makeView('laravel-common::admin.links.show',['res'=>$res]);
    }

    public function save(Request $request){
        $id = $request->query('id',0);
        Links::updateOrCreate(['id'=>$id,'pid'=>$request->input('pid',0),],$request->all());
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>'/common_admin/links/show']]);
    }

	public function add(Request $request)
	{
		if($request->isMethod('post')) {
			$post = $request->all();
			$res['info'] = Links::create($post);
			$form_edit = $request->input('form_edit',0);
			if($res['info']->id){
				throw new ApiException(['code'=>0,'msg'=>'添加成功','data'=>['redirect'=>$form_edit?$this->index_url($post):'/common_admin/links/show']]);
			}else{
				throw new ApiException(['code'=>1,'msg'=>'添加失败','data'=>[]]);
			}
		}else{
			$res['info'] = Links::where('id',$request->query('id',0))->firstOrNew();
			return $this->makeView('laravel-admin::links.form',['res'=>$res]);
		}
	}

	public function edit(Request $request)
	{
		$res['info'] = Links::where('id',$request->query('id',0))->firstOrError();
		if($request->isMethod('post')) {
			$post = $request->all();
			$form_edit = $request->input('form_edit',0);
			if($res['info']->update($post)){
				throw new ApiException(['code'=>0,'msg'=>'修改成功','data'=>['redirect'=>$form_edit?$this->index_url($post):'/common_admin/links/show']]);
			}else{
				throw new ApiException(['code'=>1,'msg'=>'修改失败','data'=>[]]);
			}
		}else{
			return $this->makeView('laravel-admin::links.form',['res'=>$res]);
		}
	}

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            Links::destroy($post);
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }


}
