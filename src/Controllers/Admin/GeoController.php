<?php

namespace Aphly\LaravelCommon\Controllers\Admin;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelCommon\Models\Country;
use Aphly\LaravelCommon\Models\Geo;
use Aphly\LaravelCommon\Models\GeoGroup;
use Aphly\LaravelCommon\Models\Zone;
use Illuminate\Http\Request;

class GeoController extends Controller
{
    public $index_url='/common_admin/geo/index';

    public function index(Request $request)
    {
        $res['search']['name'] = $request->query('name',false);
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = GeoGroup::when($res['search']['name'],
                function($query,$name) {
                    return $query->where('name', 'like', '%'.$name.'%');
                })
            ->orderBy('id','desc')
            ->Paginate(config('admin.perPage'))->withQueryString();
        return $this->makeView('laravel-common::admin.geo.index',['res'=>$res]);
    }

    public function form(Request $request)
    {
        $res['geo'] = [];
        $res['geoGroup'] = GeoGroup::where('id',$request->query('id',0))->firstOrNew();
        $res['country'] = (new Country)->findAll();
        if($res['geoGroup']->id){
            $res['geo'] = Geo::where('geo_group_id',$res['geoGroup']->id)->get();
            $geoArr = $res['geo']->toArray();
            if($geoArr){
                $country_ids = array_column($geoArr,'country_id');
                $res['country_zone'] = (new Zone)->findAllByCountrys($country_ids);
            }
        }
        return $this->makeView('laravel-common::admin.geo.form',['res'=>$res]);
    }

    public function save(Request $request){
        $id = $request->query('id',0);
        $input = $request->all();
        $input['date_add'] = time();
        $geoGroup = GeoGroup::updateOrCreate(['id'=>$id],$input);
        if($geoGroup->id){
            $val_arr = $request->input('value',[]);
            $filter = Geo::where('geo_group_id',$geoGroup->id)->pluck('id')->toArray();
            $val_arr_keys = array_keys($val_arr);
            $update_arr = $delete_arr = [];
            foreach ($filter as $val){
                if(!in_array($val,$val_arr_keys)){
                    $delete_arr[] = $val;
                }
            }
            Geo::whereIn('id',$delete_arr)->delete();
            foreach ($val_arr as $key=>$val){
                foreach ($val as $k=>$v){
                    $update_arr[$key][$k]=$v;
                }
                $update_arr[$key]['id'] = intval($key);
                $update_arr[$key]['geo_group_id'] = $geoGroup->id;
            }
            Geo::upsert($update_arr,['id'],['country_id','zone_id']);
        }
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            GeoGroup::whereIn('id',$post)->delete();
            Geo::whereIn('geo_group_id',$post)->delete();
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }

    public function ajax(Request $request){
        $name = $request->query('name',false);
        $list = Geo::leftJoin('common_geo_group as group','group.id','=','common_geo.geo_group_id')
            ->when($name,
                function($query,$name) {
                    return $query->where('common_geo.name', 'like', '%'.$name.'%');
                })
            ->selectRaw("common_geo.*,concat(group.name,' \> ',common_geo.name) as name_all")
            ->get()->toArray();
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['list'=>$list]]);
    }

}
