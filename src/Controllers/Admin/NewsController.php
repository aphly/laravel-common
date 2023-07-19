<?php

namespace Aphly\LaravelCommon\Controllers\Admin;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Libs\Editor;
use Aphly\Laravel\Models\Breadcrumb;
use Aphly\Laravel\Models\UploadFile;
use Aphly\LaravelCommon\Models\News;
use Aphly\LaravelCommon\Models\NewsCategory;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public $index_url = '/common_admin/news/index';

    private $currArr = ['name'=>'新闻','key'=>'news'];

    public $imgSize = 1;

    public function index(Request $request)
    {
        $res['search']['title'] = $request->query('title', '');
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = News::when($res['search'],
                            function ($query, $search) {
                                if($search['title']!==''){
                                    $query->where('title', 'like', '%' . $search['title'] . '%');
                                }
                            })
                        ->orderBy('id', 'desc')
                        ->Paginate(config('admin.perPage'))->withQueryString();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url]
        ]);
        return $this->makeView('laravel-common::admin.news.index', ['res' => $res]);
    }

    public function form(Request $request)
    {
        $res['info'] = News::where('id',$request->query('id',0))->firstOrNew();
        $res['newsCategoryList'] = NewsCategory::orderBy('sort', 'desc')->get()->keyBy('id')->toArray();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
            ['name'=>$res['info']->id?'编辑':'新增','href'=>'/common_admin/'.$this->currArr['key'].($res['info']->id?'/form?id='.$res['info']->id:'/form')]
        ]);
        $res['imgSize'] = $this->imgSize;
        return $this->makeView('laravel-common::admin.news.form',['res'=>$res]);
    }

    public function save(Request $request){
        $id = $request->query('id',0);
        $input = $request->all();
        $info = News::where('id',$id)->first();
        if(!empty($info)){
            $input['content'] = (new Editor)->edit($info->content,$request->input('content'));
            $info->update($input);
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

    public function uploadImg(Request $request){
        $file = $request->file('newsImg');
        if($file){
            $UploadFile = (new UploadFile($this->imgSize));
            try{
                $image = $UploadFile->upload($file,'public/editor_temp/news');
            }catch(ApiException $e){
                $err = ["errno"=>$e->code,"message"=>$e->msg];
                return $err;
            }
            $res = ["errno"=>0,"data"=>["url"=>$UploadFile->getPath($image)]];
        }else{
            $res = ["errno"=>1,"data"=>[]];
        }
        return $res;
    }


}
