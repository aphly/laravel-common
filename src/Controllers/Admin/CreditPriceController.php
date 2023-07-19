<?php

namespace Aphly\LaravelCommon\Controllers\Admin;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\Breadcrumb;
use Aphly\LaravelCommon\Models\CreditPrice;
use Aphly\LaravelCommon\Models\UserCredit;
use Illuminate\Http\Request;

class CreditPriceController extends Controller
{
    public $index_url='/common_admin/credit_price/index';

    private $currArr = ['name'=>'积分价格','key'=>'credit_price'];

    public function index(Request $request)
    {
        $res['search']['credit_key'] = $request->query('credit_key','');
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = CreditPrice::when($res['search']['credit_key'],
                function($query,$search) {
                    if($search['credit_key']!==''){
                        $query->where('credit_key',$search['credit_key']);
                    }
                })
            ->orderBy('id','desc')
            ->Paginate(config('admin.perPage'))->withQueryString();
        $res['credit_key'] = UserCredit::CreditKey;
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'],'href'=>$this->index_url]
        ]);
        return $this->makeView('laravel-common::admin.credit_price.index',['res'=>$res]);
    }

    public function form(Request $request)
    {
        $res['info'] = CreditPrice::where('id',$request->query('id',0))->firstOrNew();
        $res['credit_key'] = UserCredit::CreditKey;
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'],'href'=>$this->index_url],
            ['name'=>$res['info']->id?'编辑':'新增','href'=>'/common_admin/'.$this->currArr['key'].($res['info']->id?'/form?id='.$res['info']->id:'/form')]
        ]);
        return $this->makeView('laravel-common::admin.credit_price.form',['res'=>$res]);
    }

    public function save(Request $request){
        CreditPrice::updateOrCreate(['id'=>$request->query('id',0)],$request->all());
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            CreditPrice::whereIn('id',$post)->delete();
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }

}
