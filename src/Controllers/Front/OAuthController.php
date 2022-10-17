<?php

namespace Aphly\LaravelCommon\Controllers\Front;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Libs\Helper;
use Aphly\LaravelCommon\Models\User;
use Aphly\LaravelCommon\Models\UserAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class OAuthController extends Controller
{
    protected $providers = [
//        'github',
//        'facebook',
//        'google',
//        'twitter'
    ];

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $auth = Auth::guard('user');
            if ($auth->check()) {
                return redirect(url(''));
            }else{
                return $next($request);
            }
        });
        parent::__construct();
        $this->providers = config('common.oauth.providers');
    }

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
        //dd($oauthUser);
        return $this->loginOrCreateAccount($oauthUser, $driver);
    }

    protected function loginOrCreateAccount($oauthUser, $driver)
    {
        if(config('common.oauth.type') =='email'){
            $arr['id'] = $oauthUser->email;
            $arr['id_type'] = 'email';
            $note = $driver.' - '.$oauthUser->id;
        }else{
            $arr['id'] = $oauthUser->id;
            $arr['id_type'] = $driver;
            $note = $driver.' - '.$oauthUser->email;
        }
        $userAuthModel = UserAuth::where($arr);
        $userAuth = $userAuthModel->first();
        if(!empty($userAuth)){
            $userAuthModel->update(['password'=>$oauthUser->token,'last_login'=>time(),'last_ip'=>request()->ip()]);
            $user = User::find($userAuth->uuid);
            $user->generateToken();
            $user->afterLogin();
        }else{
            $arr['uuid'] = Helper::uuid();
            $arr['password'] = $oauthUser->token;
            $arr['last_login'] = time();
            $arr['last_ip'] = request()->ip();
            $arr['note'] = $note;
            $userAuth = UserAuth::create($arr);
            if($userAuth->uuid){
                $user = User::create([
                    'nickname'=>str::random(8),
                    'uuid'=>$userAuth->uuid,
                    'token'=>Str::random(64),
                    'token_expire'=>time()+120*60,
                    'group_id'=>User::$group_id,
                ]);
                $user->afterRegister();
            }
        }
        Auth::guard('user')->login($user);
        return redirect($user->returnUrl());
    }
}
