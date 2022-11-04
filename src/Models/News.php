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
    //public $timestamps = false;
    protected $fillable = [
        'title','content','viewed','status','news_category_id'
    ];

    function show($news_id){
        return self::where(['id'=>$news_id,'status'=>1])->firstOrError();
    }
}
