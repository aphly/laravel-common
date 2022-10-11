<?php

namespace Aphly\LaravelCommon\Models;

use Aphly\Laravel\Libs\Helper;
use Aphly\Laravel\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;

class NewsCategory extends Model
{
    use HasFactory;
    protected $table = 'common_new_category';
    public $timestamps = false;

    protected $fillable = [
        'name','icon','pid','sort','status','description','meta_title','meta_keyword','meta_description','is_leaf'
    ];

    public function findAll(int $status=0) {
        return Cache::rememberForever('news_category'.$status, function () use ($status) {
            $category = self::when($status,function ($query,$status){
                return $query->where('status', $status);
            })->orderBy('sort', 'desc')->get()->toArray();
            return Helper::getTree($category, true);
        });
    }


}
