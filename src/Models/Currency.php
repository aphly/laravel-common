<?php

namespace Aphly\LaravelCommon\Models;

use Aphly\Laravel\Models\Model;
use Aphly\LaravelAdmin\Models\Config;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;

class Currency extends Model
{
    use HasFactory;
    protected $table = 'common_currency';
    public $timestamps = false;

    protected $fillable = [
        'name','code','symbol_left','symbol_right','decimal_place','value','status','base','default'
    ];

    public function findOneByCode($code) {
        $res = self::where('code', $code)->first();
        return !empty($res)?$res->toArray():[];
    }

    static public function findAll(Int $status=0) {
        return Cache::rememberForever('currency'.$status, function () use ($status){
            return self::when($status,function ($query,$status){
                return $query->where('status',$status);
            })->get()->keyBy('code')->toArray();
        });
    }

    static function defaultCurrency(){
        $currency_all = self::findAll();
        $default = '';
        $base = '';
        foreach($currency_all as $val){
            if($val['default']){
                $default = $val;
            }
            if($val['base']){
                $base = $val;
            }
        }
        $currency = Cookie::get('currency');
        if($currency) {
            return [$currency_all[$currency],$base];
        }else{
            return [$default,$base];
        }
    }

    static function format($price,$string = true){
        $price = floatval($price);
        list($info,$base) = self::defaultCurrency();
        if($info && $base){
            if($info['value']>0 && $base['value']>0){
                $price = $price*$info['value']/$base['value'];
            }
            $price = round($price, (int)$info['decimal_place']);
            if(!$string){
                return $price;
            }
            $string = '';
            if ($info['symbol_left']) {
                $string .= $info['symbol_left'];
            }
            $string .= number_format($price, (int)$info['decimal_place']);
            if ($info['symbol_right']) {
                $string .= $info['symbol_right'];
            }
            return $string;
        }
        return $price;
    }

}
