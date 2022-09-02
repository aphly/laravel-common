<?php

namespace Aphly\LaravelCommon\Models;

use Aphly\Laravel\Exceptions\ApiException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;
use Illuminate\Support\Facades\DB;

class UserCredit extends Model
{
    use HasFactory;
    protected $table = 'common_user_credit';
    protected $primaryKey = 'uuid';
    public $timestamps = false;

    protected $fillable = [
        'silver','gold','uuid','point'
    ];

    const CreditKey = ['point','silver','gold'];

    const point = 100; //checkin

    function handle($type,$uuid,$credit_key,$pre,$credit_val,$reason=''){
        if(in_array($credit_key,['silver','gold','point'])){
            $userCredit = $this->where(['uuid'=>$uuid])->lockForUpdate()->first();
            if(!empty($userCredit) && intval($credit_val)>=0){
                if($pre=='+'){
                    $userCredit->credit_key += $credit_val;
                }else if($pre=='-'){
                    if($userCredit->credit_key<$credit_val){
                        throw new ApiException(['code'=>3,'msg'=>'credit not enough ']);
                    }
                    $userCredit->credit_key -= $credit_val;
                }else{
                    throw new ApiException(['code'=>4,'msg'=>'credit pre error ']);
                }
                if($userCredit->save()){
                    UserCreditLog::create([
                        'uuid'=>$uuid,'pre'=>$pre,'type'=>$type,'key'=>$credit_key,'val'=>$credit_val,'reason'=>$reason
                    ]);
                }
            }else{
                throw new ApiException(['code'=>2,'msg'=>'user credit error']);
            }
        }else{
            throw new ApiException(['code'=>1,'msg'=>'credit type error ']);
        }

    }


}
