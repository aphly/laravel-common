<?php

namespace Aphly\LaravelCommon\Controllers\Front;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Libs\Helper;
use Aphly\Laravel\Libs\Seccode;
use Aphly\Laravel\Libs\UploadFile;
use Aphly\Laravel\Mail\MailSend;

use Aphly\LaravelCommon\Models\UserCheckin;
use Aphly\LaravelPayment\Models\PaymentMethod;
use Aphly\LaravelPayment\Models\Payment;
use Aphly\LaravelCommon\Mail\Forget;
use Aphly\LaravelCommon\Mail\Verify;
use Aphly\LaravelCommon\Models\CreditPrice;
use Aphly\LaravelCommon\Models\Group;
use Aphly\LaravelCommon\Models\User;
use Aphly\LaravelCommon\Models\UserAuth;
use Aphly\LaravelCommon\Models\UserCredit;
use Aphly\LaravelCommon\Models\UserCreditLog;
use Aphly\LaravelCommon\Models\UserCreditOrder;
use Aphly\LaravelCommon\Models\UserGroupOrder;
use Aphly\LaravelCommon\Requests\AccountRequest;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use function config;
use function redirect;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        if($request->isMethod('post')){
            $user = User::where(['nickname'=>$request->input('nickname')])->first();
            if(!empty($user) && ($user->uuid!=$this->user->uuid)){
                throw new ApiException(['code'=>1,'msg'=>'nickname already exists']);
            }else{
                $image = false;
                $file = $request->file('image');
                if($file){
                    $image = (new UploadFile)->upload($file,'public/account');
                    if ($image) {
                        $oldImage = $this->user->avatar;
                        $this->user->avatar = $image;
                    }
                }
                $this->user->nickname = $request->input('nickname');
                if ($this->user->save()) {
                    if($image){
                        $this->user->delAvatar($oldImage);
                    }
                    throw new ApiException(['code'=>0,'msg'=>'success']);
                } else {
                    throw new ApiException(['code'=>1,'msg'=>'upload error']);
                }
            }
        }else{
            $res['title'] = 'Account index';
            return $this->makeView('laravel-common-front::account.index',['res'=>$res]);
        }
    }

    public function autoLogin(Request $request)
    {
        try {
            $decrypted = Crypt::decryptString($request->token);
            $user = User::where('token',$decrypted)->first();
            if(!empty($user)){
                Auth::guard('user')->login($user);
                return redirect('/');
            }else{
                throw new ApiException(['code'=>2,'msg'=>'No user','data'=>['redirect'=>'/']]);
            }
        } catch (DecryptException $e) {
            throw new ApiException(['code'=>1,'msg'=>'Token_error','data'=>['redirect'=>'/']]);
        }
    }

    public function login(AccountRequest $request)
    {
        $key = 'user_login_'.$request->ip();
        if($request->isMethod('post')) {
            $arr['id'] = $request->input('id');
            $arr['id_type'] = config('common.id_type');
            $userAuthModel = UserAuth::where($arr);
            $userAuth = $userAuthModel->first();
            if(!empty($userAuth)){
                if($this->limiter($key,5)){
                    if(config('admin.seccode_login')==1 || (config('admin.seccode_login')==2 && $this->limiter($key))){
                        if(!((new Seccode())->check($request->input('code')))){
                            throw new ApiException(['code'=>11000,'msg'=>'Incorrect Code','data'=>['code'=>['Incorrect Code']]]);
                        }
                    }
                    if(Hash::check($request->input('password',''),$userAuth->password)){
                        $user = User::find($userAuth->uuid);
                        if($user->status==1){
                            $userAuthModel->update(['last_login'=>time(),'last_ip'=>$request->ip()]);
                            $user->generateToken();
                            Auth::guard('user')->login($user);
                            $user->afterLogin();
                            $user->id_type = $userAuth->id_type;
                            $user->id = $userAuth->id;
                            throw new ApiException(['code'=>0,'msg'=>'login success','data'=>['redirect'=>$user->returnUrl(),'user'=>$user]]);
                        }else{
                            throw new ApiException(['code'=>3,'msg'=>'Account blocked','data'=>['redirect'=>route('blocked')]]);
                        }
                    }else{
                        $this->limiterIncrement($key,15*60);
                        if($this->limiter($key)==1){
                            throw new ApiException(['code'=>2,'msg'=>'Incorrect email or password']);
                        }
                    }
                }else{
                    throw new ApiException(['code'=>11000,'msg'=>'Too many errors, locked out for 15 minutes','data'=>['password'=>['Too many errors, locked out for 15 minutes']]]);
                }
            }
            throw new ApiException(['code'=>11000,'msg'=>'Incorrect email or password','data'=>['password'=>['Incorrect email or password']]]);
        }else{
            $res['title'] = 'Login';
            $res['seccode'] = $this->limiter($key);
            return $this->makeView('laravel-common-front::account.login',['res'=>$res]);
        }
    }

    public function register(AccountRequest $request)
    {
        $key = 'user_register_'.$request->ip();
        if($request->isMethod('post')) {
            if (config('admin.seccode_register')==1) {
                if (!((new Seccode())->check($request->input('code')))) {
                    throw new ApiException(['code' => 11000, 'msg' => 'Incorrect Code', 'data' => ['code' => ['Incorrect Code']]]);
                }
            }
            if($this->limiter($key,1)) {
                $post = $request->all();
                $post['id_type'] = config('common.id_type');
                $post['uuid'] = Helper::uuid();
                $post['password'] = Hash::make($post['password']);
                $post['last_login'] = time();
                $post['last_ip'] = $request->ip();
                $userAuth = UserAuth::create($post);
                if ($userAuth->uuid) {
                    $user = User::create([
                        'nickname' => str::random(8),
                        'uuid' => $userAuth->uuid,
                        'token' => Str::random(64),
                        'token_expire' => time() + 120 * 60,
                        'group_id' => User::$group_id,
                    ]);
                    Auth::guard('user')->login($user);
                    $user->afterRegister();
                    $user->id_type = $userAuth->id_type;
                    $user->id = $userAuth->id;
                    if ($userAuth->id_type == 'email' && config('common.email_verify')) {
                        (new MailSend())->do($userAuth->id, new Verify($userAuth));
                    }
                    $this->limiterIncrement($key,15*60);
                    throw new ApiException(['code' => 0, 'msg' => 'Register success', 'data' => ['redirect' => $user->returnUrl(), 'user' => $user]]);
                } else {
                    throw new ApiException(['code' => 1, 'msg' => 'Register fail']);
                }
            }else{
                throw new ApiException(['code' => 2, 'msg' => 'Registration is too frequent, please wait 15 minutes']);
            }
        }else{
            $res['title'] = 'Register';
            $res['seccode'] = $this->limiter($key);
            return $this->makeView('laravel-common-front::account.register',['res'=>$res]);
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('user')->logout();
        (new User)->afterLogout();
        throw new ApiException(['code'=>0,'msg'=>'logout success','data'=>['redirect'=>'/']]);
    }

    public function emailVerify(Request $request)
    {
        $res['title'] = 'Confirm Email';
        return $this->makeView('laravel-common-front::account.email_verify',['res'=>$res]);
    }

    public function emailVerifySend(Request $request)
    {
        $user = Auth::guard('user')->user();
        if($user){
            $key = 'email_'.$request->ip();
            if($this->limiter($key,1)) {
                $userauth = UserAuth::where(['id_type' => 'email', 'uuid' => $user->uuid])->first();
                if (!empty($userauth)) {
                    (new MailSend())->do($userauth->id, new Verify($userauth));
                    $this->limiterIncrement($key,2*60);
                    throw new ApiException(['code' => 0, 'msg' => 'Email has been sent', 'data' => ['redirect' => '/']]);
                }else{
                    throw new ApiException(['code' => 1, 'msg' => 'Email not exist', 'data' => ['redirect' => '/']]);
                }
            }else{
                throw new ApiException(['code'=>2,'msg'=>'Email delivery lock 2 minutes','data'=>['redirect'=>'/']]);
            }
        }else{
            throw new ApiException(['code'=>3,'msg'=>'user error','data'=>['redirect'=>'/']]);
        }
    }

    public function emailVerifyCheck(Request $request)
    {
        $res['title'] = 'Account Email Check';
        try {
            $decrypted = Crypt::decryptString($request->token);
            $decrypted = explode(',',$decrypted);
            $uuid = $decrypted[0]??0;
            $time = $decrypted[1]??0;
            if($uuid && $time>=time()) {
                $user = User::where(['uuid'=>$uuid])->first();
                if(!empty($user)){
                    $user->update(['verified'=>1]);
                    $res['msg'] = 'Email activation succeeded';
                }else{
                    $res['msg'] = 'User not found';
                }
            }else{
                $res['msg'] =  'Token Expired';
            }
        } catch (DecryptException $e) {
            $res['msg'] =  'Token Error';
        }
        return $this->makeView('laravel-common-front::account.email_check',['res'=>$res]);
    }

    public function forget(AccountRequest $request)
    {
        if($request->isMethod('post')) {
            if (config('admin.seccode_forget')==1) {
                if (!((new Seccode())->check($request->input('code')))) {
                    throw new ApiException(['code' => 11000, 'msg' => 'Incorrect Code', 'data' => ['code' => ['Incorrect Code']]]);
                }
            }
            $userauth = UserAuth::where(['id_type'=>'email','id'=>$request->input('id')])->first();
            if(!empty($userauth)){
                (new MailSend())->do($userauth->id,new Forget($userauth));
                throw new ApiException(['code'=>0,'msg'=>'Email has been sent','data'=>['redirect'=>'/account/forget/confirmation']]);
            }else{
                throw new ApiException(['code'=>11000,'msg'=>'Email not exist','data'=>['id'=>['email not exist']]]);
            }
        }else{
            $res['title'] = 'Forget your password';
            return $this->makeView('laravel-common-front::account.forget',['res'=>$res]);
        }
    }

    public function forgetConfirmation(Request $request)
    {
        $res['title'] = 'Forget password confirmation';
        return $this->makeView('laravel-common-front::account.forget_confirmation',['res'=>$res]);
    }

    public function forgetPassword(AccountRequest $request)
    {
        try {
            $decrypted = Crypt::decryptString($request->token);
            $decrypted = explode(',',$decrypted);
            $uuid = $decrypted[0]??0;
            $time = $decrypted[1]??0;
            if($uuid && $time>=time()) {
                $userAuth = UserAuth::where(['id_type'=>'email','uuid'=>$uuid])->first();
                if(!empty($userAuth)){
                    if($request->isMethod('post')) {
                        $userAuth->changePassword($userAuth->uuid,$request->input('password'));
                        Auth::guard('user')->logout();
                        throw new ApiException(['code'=>0,'msg'=>'Password reset success','data'=>['redirect'=>route('login')]]);
                    }else{
                        $res['title'] = 'Reset Password';
                        $res['token'] = $request->token;
                        $res['userAuth'] = $userAuth;
                        return $this->makeView('laravel-common-front::account.forget-password', ['res' => $res]);
                    }
                }else{
                    throw new ApiException(['code'=>3,'msg'=>'User error','data'=>['redirect'=>route('login')]]);
                }
            }else{
                throw new ApiException(['code'=>2,'msg'=>'Token Expire','data'=>['redirect'=>route('login')]]);
            }
        } catch (DecryptException $e) {
            throw new ApiException(['code'=>1,'msg'=>'Token Error','data'=>['redirect'=>route('login')]]);
        }
    }

    public function blocked(Request $request)
    {
        $res['title'] = 'Account Blocked';
        return $this->makeView('laravel-common-front::account.blocked',['res'=>$res]);
    }

    public function group(AccountRequest $request)
    {
        if($request->isMethod('post')) {
            $input['group_id'] = $request->input('group_id');
            $group = Group::where(['status'=>1,'id'=>$input['group_id']])->first();
            if(!empty($group)){
                $input['month'] = $request->input('month');
                $input['price'] = $group->price;
                $input['amount'] = $input['total'] = $input['month']*$input['price'];
                $input['method_id'] = $request->input('method_id',1);
                $input['cancel_url'] = url('/account/group');
                $input['notify_func'] = '\Aphly\LaravelCommon\Models\UserGroupOrder@notify';
                $input['success_url'] = url('/checkout/success');
                $input['fail_url'] = url('/checkout/fail');
                $payment = (new Payment)->make($input);
                if($payment->id){
                    $input['uuid'] = $this->user['uuid'];
                    $input['payment_id'] = $payment->id;
                    $order = UserGroupOrder::create($input);
                    if($order->id){
                        $payment->pay(false);
                    }
                }
                throw new ApiException(['code'=>2,'msg'=>'Group fail','data'=>['redirect'=>'/']]);
            }else{
                throw new ApiException(['code'=>1,'msg'=>'Group error','data'=>['redirect'=>'/']]);
            }
        }else{
            $res['title'] = 'Account Group';
            $res['group'] = Group::where(['status'=>1])->get()->keyBy('id');
            $res['method'] = PaymentMethod::where(['status'=>1])->orderBy('sort','desc')->get();
            return $this->makeView('laravel-common-front::account.group',['res'=>$res]);
        }
    }

    public function credit(AccountRequest $request)
    {
        if($request->isMethod('post')) {
            $input['credit_price_id'] = $request->input('credit_price_id');
            $credit_price = CreditPrice::where(['status'=>1,'id'=>$input['credit_price_id']])->first();
            if(!empty($credit_price)){
                $input['credit_key'] = $credit_price->credit_key;
                $input['credit_val'] = $credit_price->credit_val;
                $input['gold'] = $credit_price->gold;
                $input['price'] = $credit_price->price;
                $input['amount'] = $input['total'] = $input['price'];
                $input['method_id'] = $request->input('method_id',1);
                $input['cancel_url'] = url('/account/credit');
                $input['notify_func'] = '\Aphly\LaravelCommon\Models\UserCreditOrder@notify';
                $input['success_url'] = url('/checkout/success');
                $input['fail_url'] = url('/checkout/fail');
                $payment = (new Payment)->make($input);
                if($payment->id){
                    $input['uuid'] = $this->user['uuid'];
                    $input['payment_id'] = $payment->id;
                    $order = UserCreditOrder::create($input);
                    if($order->id){
                        $payment->pay(false);
                    }
                }
                throw new ApiException(['code'=>2,'msg'=>'Group fail','data'=>['redirect'=>'/']]);
            }else{
                throw new ApiException(['code'=>1,'msg'=>'Group error','data'=>['redirect'=>'/']]);
            }
        }else{
            $res['title'] = 'Account credit';
            $res['creditPrice'] = CreditPrice::where(['status'=>1])->orderBy('sort','desc')->get();
            $res['userCredit'] = UserCredit::where('uuid',$this->user->uuid)->first();
            $res['userCreditLog'] = UserCreditLog::where('uuid',$this->user->uuid)->orderBy('id','desc')->Paginate(config('admin.perPage'))->withQueryString();
            $res['method'] = PaymentMethod::where(['status'=>1])->orderBy('sort','desc')->get();
            return $this->makeView('laravel-common-front::account.credit',['res'=>$res]);
        }
    }

    public function checkin(Request $request)
    {
        $UserCheckin = new UserCheckin;
        $info = $UserCheckin->getByUuid($this->user->uuid);
        $input = ['uuid'=>$this->user->uuid,'ua'=>$request->header('user-agent'),'ip'=>$request->ip(),'lang'=>$request->header('accept-language')];
        if(!empty($info)){
            throw new ApiException(['code'=>0,'msg'=>'Checkined','data'=>['info'=>$info]]);
        }else{
            $res['title'] = '';
            $_userCheckin = $UserCheckin->create($input);
            if($_userCheckin->id){
                $res['userCredit'] = (new UserCredit)->handle('Checkin',$this->user->uuid,'point','+',$this->config['point']['checkin'],'UserCheckin#'.$_userCheckin->id);
            }
            throw new ApiException(['code'=>0,'msg'=>'signIn_point','data'=>['res'=>$res]]);
        }
    }


}
