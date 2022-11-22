<?php

namespace Aphly\LaravelCommon\Controllers\Front;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelCommon\Models\Country;
use Aphly\LaravelCommon\Models\User;
use Aphly\LaravelCommon\Models\UserAddress;
use Aphly\LaravelCommon\Models\Zone;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index()
    {
        $res['title'] = '';
        $res['list'] = UserAddress::where(['uuid'=>User::uuid()])->orderBy('id','desc')->Paginate(config('admin.perPage'))->withQueryString();
        $country_ids = $zone_ids = [];
        foreach ($res['list'] as $val){
            $country_ids[] = $val['country_id'];
            $zone_ids[] = $val['zone_id'];
        }
        $res['country'] = (new Country)->findAllIds($country_ids);
        $res['zone'] = (new Zone)->findAllIds($zone_ids);
        return $this->makeView('laravel-common-front::account_ext.address_index',['res'=>$res]);
    }

    public function save(Request $request){
        $address_id = $request->query('address_id',0);
        if($request->isMethod('post')){
            $input = $request->all();
            if(!$address_id){
                $input['uuid'] = User::uuid();
            }
            $address = UserAddress::updateOrCreate(['uuid'=>User::uuid(),'id'=>$address_id],$input);
            $default = $request->input('default',0);
            if($default){
                $this->user->update(['address_id'=>$address->id]);
            }else{
                if($address_id == $address->id){
                    $this->user->update(['address_id'=>0]);
                }
            }
            $checkout = $request->query('checkout',0);
            if($checkout){
                throw new ApiException(['code'=>0,'msg'=>'success','data'=>['list'=>(new UserAddress)->getAddresses()]]);
            }else{
                throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>'/account/address']]);
            }
        }else{
            $res['title'] = '';
            $res['country'] = (new Country)->findAll();
            $country_keys = array_keys($res['country']);
            $res['info'] = UserAddress::where(['uuid'=>User::uuid(),'id'=>$address_id])->firstOrNew();
            if($res['info'] && in_array($res['info']->country_id,$country_keys)){
                $res['zone'] = (new Zone)->findAllByCountry($res['info']->country_id);
            }else{
                $res['zone'] = [];
            }
            return $this->makeView('laravel-common-front::account_ext.address_form',['res'=>$res]);
        }
    }

    public function remove(Request $request){
        UserAddress::where(['uuid'=>User::uuid(),'id'=>$request->id])->delete();
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>'/account/address']]);
    }

    public function country(Request $request){
        $list = (new Zone)->findAllByCountry($request->id);
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>$list]);
    }
}
