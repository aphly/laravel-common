<?php

namespace Aphly\LaravelCommon\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        'uuid','nickname','token','verified',
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

    static public function groupId() {
        $auth = Auth::guard('user');
        if($auth->check()){
            if($auth->user()->group_id>1){
                if($auth->user()->group_expire<time()){
                    $auth->user()->group_id = self::$group_id;
                    $auth->user()->save();
                }
            }
            return $auth->user()->group_id;
        }else{
            return self::$group_id;
        }
    }

    static function uuid(){
        $auth = Auth::guard('user');
        if($auth->check()){
           return $auth->user()->uuid;
        }else{
            return 0;
        }
    }

    function group(){
        return $this->hasOne(Group::class,'id','group_id');
    }

    function credit(){
        return $this->hasOne(UserCredit::class,'uuid','uuid');
    }

    public function afterLogin()
    {
        $class = [];
        $this->handle($class);
    }

    public function afterRegister()
    {
        $class = ['\Aphly\LaravelNovel\Models\UserNovelSetting'];
        $this->handle($class);
    }

    public function handle($class)
    {
        foreach ($class as $val) {
            if (class_exists($val)) {
                (new $val)->handle($this);
            }
        }
    }

    public function generateToken(){
        $this->token = Str::random(64);
        $this->token_expire = time()+120*60;
        return $this->save();
    }

    public function returnUrl(){
        $redirect = urldecode(request()->query('return_url'));
        return $redirect??'/';
    }
}
