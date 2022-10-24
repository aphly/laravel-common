<?php

namespace Aphly\LaravelShop\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;

class Subscribe extends Model
{
    use HasFactory;
    protected $table = 'shop_subscribe';
    protected $primaryKey = 'email';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'email','status'
    ];


}
