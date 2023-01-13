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
        'name','code','symbol_left','symbol_right','decimal_place','value','status','default','cn_name','timezone'
    ];

    public function findOneByCode($code) {
        $res = self::where('code', $code)->first();
        return !empty($res)?$res->toArray():[];
    }

    static public function findAll() {
        return Cache::rememberForever('currency', function (){
            return self::where('status',1)->get()->keyBy('id')->toArray();
        });
    }

    static function defaultCurr($return_curr=false){
        $currency_all = self::findAll();
        $default = '';
        foreach($currency_all as $val){
            if($val['default']==1){
                $default = $val;
            }
        }
        $currency = Cookie::get('currency');
        if($currency) {
            if($return_curr){
                return $currency_all[$currency]??[];
            }
            return [$currency_all,$default,$currency_all[$currency]];
        }else{
            if($return_curr){
                return $default;
            }
            return [$currency_all,$default,$default];
        }
    }

    static function format($price,$type = 0){
        $price = floatval($price);
        list($currency_all,$default,$info) = self::defaultCurr();
        if($currency_all && $default && $info){
            if($info['value']>0 && $default['value']>0){
                $price = $price*$info['value']/$default['value'];
            }
            $decimal_place = (int)$info['decimal_place'];
            if($decimal_place){
                $pow = pow(10,$decimal_place);
            }else{
                $pow = 100;
            }
            $price = ceil($price*$pow)/$pow;
            if($type==1){
                return $price;
            }else{
                $string = self::_format($price,$info);
                if($type==2){
                    return [$price,$string];
                }
                return $string;
            }
        }
        return $price;
    }

    static function _format($price,$info=false){
        if(!$info){
            $info = self::defaultCurr(true);
        }
        $string = '';
        if($info){
            if ($info['symbol_left']) {
                $string .= $info['symbol_left'];
            }
            $string .= $price;
            if ($info['symbol_right']) {
                $string .= $info['symbol_right'];
            }
        }
        return $string;
    }

    static function codeFormat($price,$code){
        $currency_all = self::findAll();
        $info = [];
        foreach ($currency_all as $v){
            if($v['code']==$code){
                $info = $v;
            }
        }
        $string = '';
        if($info){
            if ($info['symbol_left']) {
                $string .= $info['symbol_left'];
            }
            $string .= $price;
            if ($info['symbol_right']) {
                $string .= $info['symbol_right'];
            }
        }
        return $string;
    }
}
