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

    const point = 100; //checkin
}
