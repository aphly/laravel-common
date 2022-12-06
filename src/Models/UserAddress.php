<?php

namespace Aphly\LaravelCommon\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;

class UserAddress extends Model
{
    use HasFactory;
    protected $table = 'common_user_address';

    protected $fillable = [
        'uuid','firstname','lastname','address_1','address_2','city','postcode','country_id','zone_id','telephone'
    ];


    public function getAddress($address_id) {
        $info = self::where(['id'=>$address_id,'uuid'=>User::uuid()])->first();
        if(!empty($info)){
            $country = (new Country)->findAll();
            $zone = (new Zone)->findAll();
            return [
                'id'     		 => $info['id'],
                'firstname'      => $info['firstname'],
                'lastname'       => $info['lastname'],
                'company'        => $info['company'],
                'address_1'      => $info['address_1'],
                'address_2'      => $info['address_2'],
                'postcode'       => $info['postcode'],
                'city'           => $info['city'],
                'zone_id'        => $info['zone_id'],
                'zone_name'      => $zone[$info['zone_id']]['name']??'',
                'zone_code'      => $zone[$info['zone_id']]['code']??'',
                'country_id'     => $info['country_id'],
                'country_name'   => $country[$info['country_id']]['name']??'',
                'iso_code_2'     => $country[$info['country_id']]['iso_code_2']??'',
                'iso_code_3'     => $country[$info['country_id']]['iso_code_3']??'',
                'address_format' => $country[$info['country_id']]['address_format']??'',
                'telephone'      => $info['telephone']??''
            ];
        }else{
            return [];
        }
    }

    public function getAddresses($uuid = 0) {
        $uuid = !empty($uuid)?$uuid:User::uuid();
        $address_data = [];
        $data = self::where(['uuid'=>$uuid])->get()->toArray();
        $country = (new Country)->findAll();
        $zone = (new Zone)->findAll();
        foreach ($data as $v){
            $address_data[] = [
                'id'     		 => $v['id'],
                'firstname'      => $v['firstname'],
                'lastname'       => $v['lastname'],
                'address_1'      => $v['address_1'],
                'address_2'      => $v['address_2'],
                'postcode'       => $v['postcode'],
                'city'           => $v['city'],
                'zone_id'        => $v['zone_id'],
                'zone_name'      => $zone[$v['zone_id']]['name']??'',
                'zone_code'      => $zone[$v['zone_id']]['code']??'',
                'country_id'     => $v['country_id'],
                'country_name'   => $country[$v['country_id']]['name']??'',
                'iso_code_2'     => $country[$v['country_id']]['iso_code_2']??'',
                'iso_code_3'     => $country[$v['country_id']]['iso_code_3']??'',
                'address_format' => $country[$v['country_id']]['address_format']??'',
                'telephone'      => $v['telephone']??''
            ];
        }
        return $address_data;
    }
}
