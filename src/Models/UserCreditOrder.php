<?php

namespace Aphly\LaravelCommon\Models;

use Aphly\Laravel\Exceptions\ApiException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;
use Illuminate\Support\Facades\DB;

class UserCreditOrder extends Model
{
    use HasFactory;
    protected $table = 'common_user_credit_order';
    protected $primaryKey = 'id';
    //public $timestamps = false;

    protected $fillable = [
        'credit_key','credit_val','credit_price_id','total','payment_id','status','uuid'
    ];

    public function notify($payment)
    {
        DB::beginTransaction();
        try {
            $info = self::where(['payment_id'=>$payment->id])->lockForUpdate()->first();
            if(!empty($info)){
                $info->status=2;
                if($info->save()){
                    (new UserCredit)->handle('Buy',$info->uuid,$info->credit_key,'+',$info->credit_val,'payment_id#'.$payment->id);
                }
            }
        }catch (ApiException $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
    }

    function price(){
        return $this->hasOne(CreditPrice::class,'id','credit_price_id');
    }
}
