<?php

namespace Aphly\LaravelCommon\Controllers\Admin;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Libs\Editor;
use Aphly\Laravel\Models\Breadcrumb;
use Aphly\Laravel\Models\UploadFile;
use Aphly\LaravelCommon\Models\Article;
use Aphly\LaravelCommon\Models\ArticleCategory;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public $index_url = '/common_admin/article/index';

    private $currArr = ['name'=>'文章','key'=>'article'];

    public $imgSize = 1;

    public function index(Request $request)
    {
        $res['search']['title'] = $request->query('title', '');
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = Article::when($res['search'],
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
        return $this->makeView('laravel-common::admin.article.index', ['res' => $res]);
    }

    public function form(Request $request)
    {
        $res['info'] = Article::where('id',$request->query('id',0))->firstOrNew();
        $res['articleCategoryList'] = ArticleCategory::orderBy('sort', 'desc')->get()->keyBy('id')->toArray();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
            ['name'=>$res['info']->id?'编辑':'新增','href'=>'/common_admin/'.$this->currArr['key'].($res['info']->id?'/form?id='.$res['info']->id:'/form')]
        ]);
        $res['imgSize'] = $this->imgSize;
        return $this->makeView('laravel-common::admin.article.form',['res'=>$res]);
    }

    public function save(Request $request){
        $id = $request->query('id',0);
        $input = $request->all();
        $info = Article::where('id',$id)->first();
        if(!empty($info)){
            $input['content'] = (new Editor)->edit($info->content,$request->input('content'));
            $info->update($input);
        }else{
            $input['content'] =  (new Editor)->add($request->input('content'));
            Article::create($input);
        }
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            $data = Article::whereIn('id',$post)->get();
            foreach($data as $val){
                (new Editor)->del($val->content);
            }
            Article::whereIn('id',$post)->delete();
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }

    public function uploadImg(Request $request){
        $file = $request->file('img');
        if($file){
            $UploadFile = (new UploadFile($this->imgSize));
            try{
                $image = $UploadFile->upload($file,'public/editor_temp/article');
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
