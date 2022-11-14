<?php

namespace Aphly\LaravelCommon\Controllers\Admin;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Libs\UploadFile;
use Aphly\LaravelCommon\Models\User;
use Aphly\LaravelCommon\Models\UserAuth;
use Aphly\LaravelCommon\Models\Group;
use Aphly\LaravelCommon\Models\UserCredit;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public $index_url='/common_admin/user/index';

    public function index(Request $request)
    {
        $res['title'] = '';
        $res['search']['uuid'] = $uuid = $request->query('uuid',false);
        $res['search']['id'] = $id = urldecode($request->query('id',''));
        $res['search']['status'] = $status = $request->query('status',false);
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = User::when($status,
                                function($query,$status) {
                                    return $query->where('status', '=', $status);
                                })
                            ->when($uuid,
                            function($query,$uuid) {
                                return $query->where('uuid', '=', $uuid);
                            })
                            ->with('group')
                            ->whereHas('userAuth', function (Builder $query) use ($id) {
                                if($id){
                                    $query->where('id', 'like', '%'.$id.'%')
                                        ->where('id_type', config('common.id_type'));
                                }
                            })->orderBy('uuid', 'desc')->with('userAuth')->Paginate(config('admin.perPage'))->withQueryString();
        return $this->makeView('laravel-common::admin.user.index',['res'=>$res]);
    }

    public function edit(Request $request)
    {
        if($request->isMethod('post')) {
            $user = User::find($request->uuid);
            $post = $request->all();
            $post['group_expire'] = strtotime($post['group_expire']);
            if($user->update($post)){
                throw new ApiException(['code'=>0,'msg'=>'修改成功','data'=>['redirect'=>$this->index_url]]);
            }
            throw new ApiException(['code'=>1,'msg'=>'修改失败']);
        }else{
            $res['title'] = '';
            $res['info'] = User::where('uuid',$request->uuid)->first();
            $res['group'] = Group::get();
            return $this->makeView('laravel-common::admin.user.edit',['res'=>$res]);
        }
    }

    public function password(Request $request)
    {
        if($request->isMethod('post')) {
            $post = $request->all();
            if(!empty($post['password'])){
                (new UserAuth)->changePassword($request->uuid,$post['password']);
                throw new ApiException(['code'=>0,'msg'=>'密码修改成功','data'=>['redirect'=>$this->index_url]]);
            }
            throw new ApiException(['code'=>1,'msg'=>'修改失败']);
        }else{
            $res['title'] = '';
            $res['info'] = User::where('uuid',$request->uuid)->first();
            return $this->makeView('laravel-common::admin.user.password',['res'=>$res]);
        }
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            User::destroy($post);
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }

    public function credit(Request $request)
    {
        if($request->isMethod('post')) {
            UserCredit::updateOrCreate(['uuid'=>$request->uuid],$request->all());
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$this->index_url]]);
        }else{
            $res['title'] = '';
            $res['info'] = UserCredit::where('uuid',$request->uuid)->first();
            return $this->makeView('laravel-common::admin.user.credit',['res'=>$res]);
        }
    }

    public function avatar(Request $request)
    {
        if($request->isMethod('post')) {
            //$cache = Setting::getCache();
            //$host = $cache['oss_status'] ? $cache['siteurl'] : $cache['oss_host'];
            $file = $request->file('avatar');
            $avatar = (new UploadFile)->upload($file,'public/avatar');
            if ($avatar) {
                $user = User::find($request->uuid);
                $oldAvatar = $user->avatar;
                $user->avatar = $avatar;
                if ($user->save()) {
                    $user->delAvatar($oldAvatar);
                    throw new ApiException(['code'=>0,'msg'=>'上传成功','data'=>['redirect'=>$this->index_url,'avatar'=>Storage::url($avatar)]]);
                } else {
                    throw new ApiException(['code'=>1,'msg'=>'保存错误']);
                }
            }
            throw new ApiException(['code'=>2,'data'=>'','msg'=>'上传错误']);
        }else{
            $res['title'] = '';
            $res['info'] = User::find($request->uuid);
            return $this->makeView('laravel-common::admin.user.avatar',['res'=>$res]);
        }
    }


}
