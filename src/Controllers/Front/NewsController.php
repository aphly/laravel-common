<?php

namespace Aphly\LaravelCommon\Controllers\Front;


use Aphly\LaravelCommon\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{

    function detail(Request $request){
        $res['info'] = (new News())->show($request->id);
        $res['title'] = $res['info']->title;
        return $this->makeView('laravel-common-front::news.detail',['res'=>$res]);
    }



}
