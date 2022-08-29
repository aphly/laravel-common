<?php

namespace Aphly\LaravelCommon\Models;

use Aphly\Laravel\Libs\Helper;
use Aphly\Laravel\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;

class Link extends Model
{
    use HasFactory;
    protected $table = 'common_link';
    public $timestamps = false;

    protected $fillable = [
        'name','icon','pid','sort','status','url'
    ];

    public function menu(): array
    {
        $tree = Cache::rememberForever('link', function () {
            $tree = self::where('status', 1)->orderBy('sort', 'desc')->get()->toArray();
            return Helper::getTree($tree, true);
        });
        $links = [];
        foreach($tree as $v){
            $links[$v['id']]=$v;
        }
        return $links;
    }


}
