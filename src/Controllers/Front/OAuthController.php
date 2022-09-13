<?php

namespace Aphly\LaravelCommon\Controllers\Front;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelCommon\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        if(!$this->isProviderAllowed($driver) ) {
            throw new ApiException(['code'=>1,'msg'=>"{$driver} is not currently supported"]);
        }
        try {
            return Socialite::driver($driver)->redirect();
        } catch (\Exception $e) {
            throw new ApiException(['code'=>2,'msg'=>$e->getMessage()]);
        }
    }

    public function handleProviderCallback( $driver )
    {
        try {
            $user = Socialite::driver($driver)->user();
        } catch (\Exception $e) {
            throw new ApiException(['code'=>1,'msg'=>$e->getMessage()]);
        }
        dd($user);
        return empty( $user->email )
            ? throw new ApiException(['code'=>1,'msg'=>"No email id returned from {$driver} provider."])
            : $this->loginOrCreateAccount($user, $driver);
    }

    protected function loginOrCreateAccount($providerUser, $driver)
    {
        $user = User::where('email', $providerUser->getEmail())->first();
        // if user already found
        if( $user ) {
            // update the avatar and provider that might have changed
            $user->update([
                'avatar' => $providerUser->avatar,
                'provider' => $driver,
                'provider_id' => $providerUser->id,
                'access_token' => $providerUser->token
            ]);
        } else {
            // create a new user  我自己的github我获取不到账号的name，能获取到nickname。
            $user = User::create([
                'name' => $providerUser->getName()?:$providerUser->getNickName(),
                'email' => $providerUser->getEmail(),
                'avatar' => $providerUser->getAvatar(),
                'provider' => $driver,
                'provider_id' => $providerUser->getId(),
                'access_token' => $providerUser->token,
                // user can use reset password to create a password
                'password' => ''
            ]);
        }

        // login the user，web版的登录,原生的auth验证
        Auth::login($user, true);

        return $this->sendSuccessResponse();

    }
}
