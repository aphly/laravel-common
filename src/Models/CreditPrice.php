<?php

namespace Aphly\LaravelCommon\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;

class CreditPrice extends Model
{
    use HasFactory;
    protected $table = 'common_credit_price';
    protected $primaryKey = 'id';
    //public $timestamps = false;

    protected $fillable = [
        'credit_key','credit_val','price','sort','status'
    ];


}
