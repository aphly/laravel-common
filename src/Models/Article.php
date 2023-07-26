<?php

namespace Aphly\LaravelCommon\Models;

use Aphly\Laravel\Exceptions\ApiException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;
use Illuminate\Support\Facades\Cache;

class Article extends Model
{
    use HasFactory;
    protected $table = 'common_article';
    //public $timestamps = false;
    protected $fillable = [
        'title','content','viewed','status','article_category_id'
    ];

    function category(){
        return $this->hasOne(ArticleCategory::class,'id','article_category_id');
    }

}
