<?php

namespace Aphly\LaravelShop\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;

class BannerImage extends Model
{
    use HasFactory;
    protected $table = 'shop_banner_image';
    public $timestamps = false;

    protected $fillable = [
        'banner_id','title','link','image','sort'
    ];


}
