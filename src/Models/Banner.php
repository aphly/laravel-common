<?php

namespace Aphly\LaravelShop\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;

class Banner extends Model
{
    use HasFactory;
    protected $table = 'shop_banner';
    public $timestamps = false;

    protected $fillable = [
        'name','status'
    ];


}
