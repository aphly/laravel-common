<?php

namespace Aphly\LaravelCommon\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;
use Illuminate\Support\Facades\Cache;

class Zone extends Model
{
    use HasFactory;
    protected $table = 'common_zone';
    public $timestamps = false;

    protected $fillable = [
        'country_id','name','code','status','cn_name'
    ];

    public function findAllByCountry($country_id) {
        return Cache::rememberForever('zone_'. (int)$country_id, function () use ($country_id){
            return self::where('country_id', $country_id)->where('status',1)->orderBy('name','asc')->get()->keyBy('id')->toArray();
        });
    }

    public function findAllByCountrys($country_ids) {
        $res = [];
        foreach($country_ids as $val){
            $res[$val] = $this->findAllByCountry($val);
        }
        return $res;
    }

    public function findAll() {
        return Cache::rememberForever('zone', function (){
            return self::where('status',1)->get()->keyBy('id')->toArray();
        });
    }
}
