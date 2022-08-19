<?php

namespace Aphly\LaravelCommon\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;

class UserCreditLog extends Model
{
    use HasFactory;
    protected $table = 'common_user_credit_log';
    protected $primaryKey = 'id';
    //public $timestamps = false;

    protected $fillable = [
        'key','val','uuid','pre','type','reason'
    ];



}
