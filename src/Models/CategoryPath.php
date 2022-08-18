<?php

namespace Aphly\LaravelCommon\Models;

use Aphly\Laravel\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class CategoryPath extends Model
{
    use HasFactory;
    protected $table = 'common_category_path';
    protected $primaryKey = ['category_id','path_id'];
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'category_id','path_id','level'
    ];

    public function add($id,$pid){
        $level = 0;
        $data =  self::where('category_id',$pid)->orderBy('level','asc')->get()->toArray();
        $insertData = [];
        foreach ($data as $val){
            $insertData[] = ['category_id'=>$id,'path_id'=>$val['path_id'],'level'=>$level];
            $level++;
        }
        $insertData[] = ['category_id'=>$id,'path_id'=>$id,'level'=>$level];
        DB::table($this->table)->upsert($insertData, ['category_id', 'path_id']);
    }

    public function getByIds($ids){
        return self::leftJoin('common_category as c1','c1.id','=','common_category_path.category_id')
            ->leftJoin('common_category as c2','c2.id','=','common_category_path.path_id')
            ->whereIn('c1.id', $ids)
            ->groupBy('category_id')
            ->selectRaw('any_value(c1.`id`) AS id,any_value(common_category_path.`category_id`) AS category_id,
            GROUP_CONCAT(c2.`name` ORDER BY common_category_path.level SEPARATOR \'&nbsp;&nbsp;&gt;&nbsp;&nbsp;\') AS name')
            ->get()->keyBy('id')->toArray();
    }
}
