<?php

namespace Aphly\LaravelCommon\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;
use Illuminate\Support\Facades\Cache;

class GeoGroup extends Model
{
    use HasFactory;
    protected $table = 'common_geo_group';
    //public $timestamps = false;

    protected $fillable = [
        'name','desc','status'
    ];

    function child(){
        return $this->hasMany(Geo::class,'geo_group_id','id');
    }

    public function findAll() {
        return Cache::rememberForever('geo', function (){
            return self::get()->keyBy('geo_group_id')->toArray();
        });
    }


}
