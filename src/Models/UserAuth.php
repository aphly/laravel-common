<?php

namespace Aphly\LaravelCommon\Models;

use Aphly\Laravel\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;

class UserAuth extends Model
{
    use HasFactory;
    protected $table = 'common_user_auth';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = ['id_type','id'];
    protected $fillable = [
        'uuid','id_type','id','password','user_agent','accept_language','last_ip','last_time'
    ];

    function changePassword($uuid,$password){
        $password = Hash::make($password);
        $this->where(['id_type'=>'username','uuid'=>$uuid])->update(['password'=>$password]);
        $this->where(['id_type'=>'mobile','uuid'=>$uuid])->update(['password'=>$password]);
        $this->where(['id_type'=>'email','uuid'=>$uuid])->update(['password'=>$password]);
        return true;
    }


//    protected static function boot()
//    {
//        parent::boot();
//        static::created(function (UserAuth $user) {
//            $post['uuid'] = $post['token'] = $user->uuid;
//            $post['token_expire'] = time();
//            User::create($post);
//        });
//
//    }
}
