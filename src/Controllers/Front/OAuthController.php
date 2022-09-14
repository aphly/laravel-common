<?php

namespace Aphly\LaravelCommon\Controllers\Front;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Libs\Helper;
use Aphly\LaravelCommon\Models\User;
use Aphly\LaravelCommon\Models\UserAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class OAuthController extends Controller
{
    protected $providers = [
        'github',
        'facebook',
        'google',
        'twitter'
    ];

    private function isProviderAllowed($driver)
    {
        return in_array($driver, $this->providers) && config()->has("services.{$driver}");
    }

    public function redirectToProvider($driver)
    {
        if(!$this->isProviderAllowed($driver)) {
            throw new ApiException(['code'=>1,'msg'=>"{$driver} is not currently supported"]);
        }
        try {
            return Socialite::driver($driver)->redirect();
        } catch (\Exception $e) {
            throw new ApiException(['code'=>2,'msg'=>$e->getMessage()]);
        }
    }

    public function handleProviderCallback($driver)
    {
        try {
            //$oauthUser = Socialite::driver($driver)->stateless()->user();
            $oauthUser = Socialite::driver($driver)->user();
        } catch (\Exception $e) {
            throw new ApiException(['code'=>1,'msg'=>$e->getMessage()]);
        }
        return $this->loginOrCreateAccount($oauthUser, $driver);
    }

    protected function loginOrCreateAccount($oauthUser, $driver)
    {
        $arr['id'] = $oauthUser->id;
        $arr['id_type'] = $driver;
        $userAuthModel = UserAuth::where($arr);
        $userAuth = $userAuthModel->first();
        if(!empty($userAuth)){
            $userAuthModel->update(['password'=>$oauthUser->token,'last_login'=>time(),'last_ip'=>request()->ip()]);
            $user = User::find($userAuth->uuid);
            $user->generateToken();
            $user->afterLogin($user);
        }else{
            $arr['uuid'] = Helper::uuid();
            $arr['password'] = $oauthUser->token;
            $arr['last_login'] = time();
            $arr['last_ip'] = request()->ip();
            $userAuth = UserAuth::create($arr);
            if($userAuth->uuid){
                $user = User::create([
                    'nickname'=>str::random(8),
                    'uuid'=>$userAuth->uuid,
                    'token'=>Str::random(64),
                    'token_expire'=>time()+120*60,
                    'group_id'=>User::$group_id,
                ]);
                $user->afterRegister($user);
            }
        }
        Auth::guard('user')->login($user);
        return redirect($user->returnUrl());
    }
}
