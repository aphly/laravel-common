<?php

namespace Aphly\LaravelCommon\Models;

use Aphly\Laravel\Libs\Helper;
use Aphly\Laravel\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;

class NewsCategory extends Model
{
    use HasFactory;
    protected $table = 'common_news_category';
    public $timestamps = false;

    protected $fillable = [
        'name','icon','pid','sort','status','meta_title','meta_description','is_leaf'
    ];

    public function findAll() {
        return Cache::rememberForever('news_category', function () {
            $category = self::where('status', 1)->orderBy('sort', 'desc')->get()->toArray();
            return Helper::getTree($category, true);
        });
    }


}
