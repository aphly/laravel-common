<?php

namespace Aphly\LaravelCommon\Controllers\Front;

use Aphly\Laravel\Libs\Helper;
use Aphly\LaravelCommon\Models\Article;
use Aphly\LaravelCommon\Models\ArticleCategory;
use Aphly\LaravelCommon\Models\ArticleCategoryPath;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    function category(Request $request){
        $res['title'] = 'Artcle Home';
        $res['search']['title'] = $request->query('title', '');
        $res['list'] = ArticleCategory::where('status',1)->get()->toArray();
        $res['list_tree'] = Helper::getTree($res['list'],true);
        return $this->makeView('laravel-common-front::article.category',['res'=>$res]);
    }

    function index(Request $request){
        $res['title'] = 'Artcle Index';
        $res['search']['title'] = $request->query('title', '');
        $res['search']['category_id'] = $request->query('category_id', '');
        $res['list'] = Article::when($res['search'],
            function ($query, $search) {
                if($search['title']!==''){
                    $query->where('title', 'like', '%' . $search['title'] . '%');
                }
                if($search['category_id']!==''){
                    $paths = ArticleCategoryPath::where('path_id',$search['category_id'])->get()->toArray();
                    if($paths){
                        $path_category = array_column($paths,'article_category_id');
                        $query->whereIn('article_category_id', $path_category);
                    }
                }
            })
            ->orderBy('id', 'desc')
            ->Paginate(config('admin.perPage'))->withQueryString();
        $res['paths'] = ArticleCategoryPath::where('article_category_id',$res['search']['category_id'])->with('category_p')->orderBy('level','asc')->get()->toArray();
        return $this->makeView('laravel-common-front::article.index',['res'=>$res]);
    }

    function detail(Request $request){
        $res['info'] = Article::where(['status'=>1,'id'=>$request->id])->with('category')->firstOr404();
        $res['paths'] = ArticleCategoryPath::where('article_category_id',$res['info']->article_category_id)->with('category_p')->orderBy('level','asc')->get()->toArray();
        $res['title'] = $res['info']->title;
        return $this->makeView('laravel-common-front::article.detail',['res'=>$res]);
    }

}
