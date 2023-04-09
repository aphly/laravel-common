<?php

namespace Aphly\LaravelCommon\Controllers\Front;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\UploadFile;
use Aphly\LaravelCommon\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{

    function detail(Request $request){
        $res['info'] = (new News())->show($request->id);
        $res['title'] = $res['info']->title;
        return $this->makeView('laravel-common-front::news.detail',['res'=>$res]);
    }

    public function imgs(Request $request){
        $file = $request->file('newsImg');
        if($file){
            try{
                $image = (new UploadFile)->upload($file,'public/editor_temp');
            }catch(ApiException $e){
                $err = ["errno"=>$e->code,"message"=>$e->msg];
                return $err;
            }
            $res = ["errno"=>0,"data"=>["url"=>Storage::url($image)]];
        }else{
            $res = ["errno"=>1,"data"=>[]];
        }
        return $res;
    }

}
