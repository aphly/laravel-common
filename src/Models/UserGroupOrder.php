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
                    User::where('uuid',$info->uuid)->update([
                        'group_id'=>2,
                        'group_expire'=>DB::raw('group_expire+'.$info->month*30*24*3600),
                    ]);
                }
            }
        }catch (ApiException $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
    }
}
