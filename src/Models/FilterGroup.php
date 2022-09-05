<?php

namespace Aphly\LaravelCommon\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;

class FilterGroup extends Model
{
    use HasFactory;
    protected $table = 'common_filter_group';
    public $timestamps = false;

    protected $fillable = [
        'name','sort','status'
    ];

    function filter(){
        return $this->hasMany(Filter::class,'filter_group_id','id');
    }
}
