<?php

namespace Aphly\LaravelCommon\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;

class UserSignIn extends Model
{
    use HasFactory;
    protected $table = 'common_user_sign_in';
    protected $primaryKey = 'id';

    protected $fillable = [
        'ip','ua','uuid'
    ];


}
