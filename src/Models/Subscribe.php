<?php

namespace Aphly\LaravelCommon\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;

class Subscribe extends Model
{
    use HasFactory;
    protected $table = 'common_subscribe';
    protected $primaryKey = 'id';

    //public $timestamps = false;

    protected $fillable = [
        'email','status'
    ];


}
