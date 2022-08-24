<?php

namespace Aphly\LaravelCommon\Controllers\Admin;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelCommon\Models\Filter;
use Aphly\LaravelCommon\Models\FilterGroup;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public $index_url='/common_admin/filter/index';

    public function index(Request $request)
    {
        $res['search']['name'] = $name = $request->query('name',false);
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = FilterGroup::when($name,
                function($query,$name) {
                    return $query->where('name', 'like', '%'.$name.'%');
                })
            ->orderBy('id','desc')
            ->Paginate(config('admin.perPage'))->withQueryString();
        //$res['fast_save'] = Category::where('status',1)->orderBy('sort', 'desc')->get()->toArray();
        return $this->makeView('laravel-common::admin.filter.index',['res'=>$res]);
    }

    public function form(Request $request)
    {
        $res['filter'] = [];
        $res['filterGroup'] = FilterGroup::where('id',$request->query('id',0))->firstOrNew();
        if($res['filterGroup']->id){
            $res['filter'] = Filter::where('filter_group_id',$res['filterGroup']->id)->orderBy('sort','desc')->get();
        }
        return $this->makeView('laravel-common::admin.filter.form',['res'=>$res]);
    }

    public function save(Request $request){
        $id = $request->query('id',0);
        $filterGroup = FilterGroup::updateOrCreate(['id'=>$id],$request->all());
        if($filterGroup->id){
            $val_arr = $request->input('value',[]);
            $filter = Filter::where('filter_group_id',$filterGroup->id)->pluck('id')->toArray();
            $val_arr_keys = array_keys($val_arr);
            $update_arr = $delete_arr = [];
            foreach ($filter as $val){
                if(!in_array($val,$val_arr_keys)){
                    $delete_arr[] = $val;
                }
            }
            Filter::whereIn('id',$delete_arr)->delete();
            foreach ($val_arr as $key=>$val){
                foreach ($val as $k=>$v){
                    $update_arr[$key][$k]=$v;
                }
                $update_arr[$key]['id'] = intval($key);
                $update_arr[$key]['filter_group_id'] = $filterGroup->id;
            }
            Filter::upsert($update_arr,['id'],['filter_group_id','name','sort']);
        }
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            FilterGroup::whereIn('id',$post)->delete();
            Filter::whereIn('filter_group_id',$post)->delete();
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }

    public function ajax(Request $request){
        $name = $request->query('name',false);
        $list = Filter::leftJoin('common_filter_group as group','group.id','=','common_filter.filter_group_id')
            ->when($name,
                function($query,$name) {
                    return $query->where('common_filter.name', 'like', '%'.$name.'%');
                })
            ->where('group.status', 1)
            ->selectRaw("common_filter.*,concat(group.name,' \> ',common_filter.name) as name_all,group.status as status")
            ->get()->toArray();
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['list'=>$list]]);
    }

}
