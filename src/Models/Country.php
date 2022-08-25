<?php

namespace Aphly\LaravelCommon\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;
use Illuminate\Support\Facades\Cache;

class Country extends Model
{
    use HasFactory;
    protected $table = 'common_country';
    public $timestamps = false;

    protected $fillable = [
        'name','iso_code_2','iso_code_3','postcode_required','status','address_format'
    ];

    public function findAll(Int $status=0) {
        return Cache::rememberForever('country'.$status, function () use ($status){
            return self::when($status,function ($query,$status){
                return $query->where('status',$status)->orderBy('name','asc');
            })->get()->keyBy('id')->toArray();
        });
    }
}
