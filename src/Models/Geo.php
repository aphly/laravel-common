<?php

namespace Aphly\LaravelCommon\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;
use Illuminate\Support\Facades\Cache;

class Geo extends Model
{
    use HasFactory;
    protected $table = 'common_geo';
    public $timestamps = false;

    protected $fillable = [
        'country_id','zone_id','geo_group_id'
    ];

    function group(){
        return $this->hasOne(GeoGroup::class,'id','geo_group_id');
    }

    public function findAll() {
        return Cache::rememberForever('geo', function (){
            return self::get()->keyBy('geo_group_id')->toArray();
        });
    }

    public function isExist($country_id,$zone_id,$geo_group_id) {
        $status = false;
        $arr = self::where('geo_group_id',$geo_group_id)->get()->keyBy('country_id')->toArray();
        if(isset($arr[$country_id])){
            foreach ($arr[$country_id] as $val){
                if($val['zone_id'] == 0 || $val['zone_id'] == $zone_id){
                    $status = true;
                    break;
                }
            }
        }
        return $status;
    }
}
