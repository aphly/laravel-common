<?php

namespace Aphly\LaravelCommon\Controllers\Admin;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\Breadcrumb;
use Aphly\Laravel\Models\UploadFile;
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

    private $currArr = ['name'=>'用户','key'=>'user'];

    public function index(Request $request)
    {
        $res['title'] = '';
        $res['search']['uuid'] = $request->query('uuid','');
        $res['search']['id'] = $id = urldecode($request->query('id',''));
        $res['search']['status'] = $request->query('status','');
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = User::when($res['search'],
                                function($query,$search) {
                                    if($search['status']!==''){
                                        $query->where('status', '=', $search['status']);
                                    }
                                    if($search['uuid']!==''){
                                        $query->where('uuid', '=', $search['uuid']);
                                    }
                                })
                            ->with('group')
                            ->whereHas('userAuth', function (Builder $query) use ($id) {
                                if($id){
                                    $query->where('id', 'like', '%'.$id.'%')
                                        ->where('id_type', config('common.id_type'));
                                }
                            })->orderBy('uuid', 'desc')->with('userAuth')->Paginate(config('admin.perPage'))->withQueryString();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url]
        ]);
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
            $res['info'] = User::where('uuid',$request->uuid)->firstOrError();
            $res['breadcrumb'] = Breadcrumb::render([
                ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
                ['name'=>'编辑','href'=>'/common_admin/'.$this->currArr['key'].'/'.$res['info']->uuid.'/edit']
            ]);
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
            $res['info'] = User::where('uuid',$request->uuid)->firstOrError();
            $res['breadcrumb'] = Breadcrumb::render([
                ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
                ['name'=>'密码','href'=>'/common_admin/'.$this->currArr['key'].'/'.$res['info']->uuid.'/password']
            ]);
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
            $res['info'] = UserCredit::where('uuid',$request->uuid)->firstOrError();
            $res['breadcrumb'] = Breadcrumb::render([
                ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
                ['name'=>'积分','href'=>'/common_admin/'.$this->currArr['key'].'/'.$res['info']->uuid.'/credit']
            ]);
            return $this->makeView('laravel-common::admin.user.credit',['res'=>$res]);
        }
    }

    public function avatar(Request $request)
    {
        $res['info'] = User::where('uuid',$request->uuid)->firstOrError();
        if($request->isMethod('post')) {
            if($request->hasFile('avatar')){
                $UploadFile = new UploadFile(1);
                $res['info']->remote = $UploadFile->isRemote();
                $avatar = $UploadFile->upload($request->file('avatar'),'public/avatar');
                $oldAvatar = $res['info']->avatar;
                $res['info']->avatar = $avatar;
                if ($res['info']->save()) {
                    $res['info']->delAvatar($oldAvatar);
                    throw new ApiException(['code'=>0,'msg'=>'上传成功','data'=>['redirect'=>$this->index_url,'avatar'=>Storage::url($avatar)]]);
                } else {
                    throw new ApiException(['code'=>1,'msg'=>'保存错误']);
                }
            }else{
                throw new ApiException(['code'=>2,'data'=>'','msg'=>'上传错误']);
            }
        }else{
            $res['breadcrumb'] = Breadcrumb::render([
                ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
                ['name'=>'头像','href'=>'/common_admin/'.$this->currArr['key'].'/'.$res['info']->uuid.'/avatar']
            ]);
            return $this->makeView('laravel-common::admin.user.avatar',['res'=>$res]);
        }
    }


}
