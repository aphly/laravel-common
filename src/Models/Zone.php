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
        'country_id','name','code','status'
    ];

    public function findAllByCountry($country_id,Int $status=0) {
        return Cache::rememberForever('zone_'. (int)$country_id.'_'.$status, function () use ($country_id,$status){
            return self::where('country_id', $country_id)->when($status,function ($query,$status){
                return $query->where('status',$status);
            })->orderBy('name','asc')->get()->keyBy('id')->toArray();
        });
    }

    public function findAllByCountrys($country_ids) {
        $res = [];
        foreach($country_ids as $val){
            $res[$val] = $this->findAllByCountry($val);
        }
        return $res;
    }

    public function findAll(Int $status=0) {
        return Cache::rememberForever('zone'.$status, function () use ($status){
            return self::when($status,function ($query,$status){
                return $query->where('status',$status);
            })->get()->keyBy('code')->toArray();
        });
    }
}
