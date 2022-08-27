<?php

namespace Aphly\LaravelCommon\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'common_user';
    protected $primaryKey = 'uuid';
    public $incrementing = false;

    static public $group_id = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public function fromDateTime($value){
        return strtotime(parent::fromDateTime($value));
    }

    protected $fillable = [
        'uuid','nickname',
        'token',
        'token_expire','avatar','status','gender','group_id','group_expire'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
       //'email_verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::created(function (User $user) {
            UserCredit::create(['uuid'=>$user->uuid]);
        });

        static::deleted(function (User $user) {
            UserCredit::destroy($user->uuid);
            //self::delAvatar($user->avatar);
        });
    }

    public function userAuth()
    {
        return $this->hasMany(UserAuth::class,'uuid');
    }

    static public function delAvatar($avatar) {
        if($avatar){
            Storage::delete($avatar);
        }
    }

    public function group_id() {
        if($this->group_id>1){
            if($this->group_expire<time()){
                $this->group_id = self::$group_id;
                $this->save();
            }
        }
        return $this->group_id;
    }

    function group(){
        return $this->hasOne(Group::class,'id','group_id');
    }

    function credit(){
        return $this->hasOne(UserCredit::class,'uuid','uuid');
    }
}
