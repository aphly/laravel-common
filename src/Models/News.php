<?php

namespace Aphly\LaravelCommon\Models;

use Aphly\Laravel\Exceptions\ApiException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;
use Illuminate\Support\Facades\Cache;

class News extends Model
{
    use HasFactory;
    protected $table = 'common_news';
    public $timestamps = false;
    protected $fillable = [
        'title','content','viewed','status'
    ];

    function show($news_id){
        $info = self::where(['id'=>$news_id,'status'=>1])->first();
        if(!empty($info)){
            return $info;
        }else{
            throw new ApiException(['code'=>1,'msg'=>'news show fail','data'=>[]]);
        }
    }
}
