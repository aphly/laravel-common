<?php

namespace Aphly\LaravelCommon\Models;

use Aphly\Laravel\Exceptions\ApiException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;
use Illuminate\Support\Facades\DB;

class UserGroupOrder extends Model
{
    use HasFactory;
    protected $table = 'common_user_group_order';
    protected $primaryKey = 'id';
    //public $timestamps = false;

    protected $fillable = [
        'uuid','group_id','month','price','total','payment_id','status'
    ];

    public function notify($payment)
    {
        DB::beginTransaction();
        try {
            $info = self::where(['payment_id'=>$payment->id])->lockForUpdate()->first();
            if(!empty($info)){
                $info->status=2;
                if($info->save()){
                    $userInfo = User::where('uuid',$info->uuid)->first();
                    if(!empty($userInfo) ){
                        $curr_time = time();
                        if($userInfo->group_id == $info->group_id){

                        }else{
                            $userInfo->group_id = $info->group_id;
                        }
                        if($userInfo->group_expire<$curr_time){
                            $userInfo->group_expire = $curr_time+$info->month*30*24*3600;
                        }else{
                            $userInfo->group_expire += $info->month*30*24*3600;
                        }

                        $userInfo->save();
                    }
                }
            }
        }catch (ApiException $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
    }
}
