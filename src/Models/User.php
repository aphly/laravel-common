<?php

namespace Aphly\LaravelCommon\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'common_user';
    protected $primaryKey = 'uuid';
    public $incrementing = false;

    static public $group_id = 1;

	static public $uuid = 0;

    static public $id = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public function fromDateTime($value){
        return strtotime(parent::fromDateTime($value));
    }

    protected $fillable = [
        'uuid','nickname','token','verified','address_id',
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
            $user = $auth->user();
            if($user->group_id>1){
                if($user->group_expire<time()){
                    $user->group_id = self::$group_id;
                    $user->save();
                }
            }
            return $user->group_id;
        }else{
            return 0;
        }
    }

    static function uuid(){
    	if(!self::$uuid){
			$auth = Auth::guard('user');
			if($auth->check()){
				return self::$uuid = $auth->user()->uuid;
			}else{
				return 0;
			}
		}else{
			return self::$uuid;
		}
    }

    function group(){
        return $this->hasOne(Group::class,'id','group_id');
    }

    function credit(){
        return $this->hasOne(UserCredit::class,'uuid','uuid');
    }

    function initId(){
        if(!self::$id){
            $arr['id_type'] = config('common.id_type');
            $arr['uuid'] = $this->uuid;
            $userAuthModel = UserAuth::where($arr)->first();
            self::$id = $userAuthModel->id;
        }
        return self::$id;
    }

    public function afterRegister()
    {
        $class = ['\Aphly\LaravelNovel\Models\UserNovelSetting','\Aphly\LaravelShop\Models\Account\Wishlist',
            '\Aphly\LaravelShop\Models\Checkout\Cart'];
        foreach ($class as $val) {
            if (class_exists($val)) {
                (new $val)->afterRegister($this);
            }
        }
    }

    public function afterLogin()
    {
        $class = ['\Aphly\LaravelShop\Models\Checkout\Cart','\Aphly\LaravelShop\Models\Account\Wishlist'];
        foreach ($class as $val) {
            if (class_exists($val)) {
                (new $val)->afterLogin($this);
            }
        }
    }

    public function afterLogout()
    {
        $class = [];
        foreach ($class as $val) {
            if (class_exists($val)) {
                (new $val)->afterLogout();
            }
        }
    }


    public function generateToken(){
        $this->token = Str::random(64);
        $this->token_expire = time()+120*60;
        return $this->save();
    }

    public function redirect(){
        $redirect = request()->query('redirect',false);
        if($redirect){
            return urldecode($redirect);
        }
        return '/';
    }
}
