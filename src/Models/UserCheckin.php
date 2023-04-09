<?php

namespace Aphly\LaravelCommon\Models;

use Aphly\Laravel\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserCheckin extends Model
{
    use HasFactory;
    protected $table = 'common_user_checkin';

    protected $fillable = [
        'uuid','ip','ua','lang'
    ];

    function getByUuid($uuid){
        return self::where(['uuid'=>$uuid])->whereBetween('created_at',[mktime(0,0,0,date('m'),date('d'),date('Y')),mktime(23,59,59,date('m'),date('d'),date('Y'))])->first();

    }
}
