<?php

namespace Aphly\LaravelCommon\Models;

use Aphly\Laravel\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class ArticleCategoryPath extends Model
{
    use HasFactory;
    protected $table = 'common_article_category_path';
    protected $primaryKey = ['article_category_id','path_id'];
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'article_category_id','path_id','level'
    ];

    function category_p(){
        return $this->hasOne(ArticleCategory::class,'id','path_id');
    }

    function category_child(){
        return $this->hasOne(ArticleCategory::class,'id','article_category_id');
    }

    public function add($id,$pid){
        $level = 0;
        $data =  self::where('article_category_id',$pid)->orderBy('level','asc')->get()->toArray();
        $insertData = [];
        foreach ($data as $val){
            $insertData[] = ['article_category_id'=>$id,'path_id'=>$val['path_id'],'level'=>$level];
            $level++;
        }
        $insertData[] = ['article_category_id'=>$id,'path_id'=>$id,'level'=>$level];
        DB::table($this->table)->upsert($insertData, ['article_category_id', 'path_id']);
    }

    public function getByIds($ids){
        return self::leftJoin('comon_article_category as c1','c1.id','=','comon_article_category_path.category_id')
            ->leftJoin('comon_article_category as c2','c2.id','=','comon_article_category_path.path_id')
            ->whereIn('c1.id', $ids)
            ->groupBy('category_id')
            ->selectRaw('any_value(c1.`id`) AS id,any_value(comon_article_category_path.`category_id`) AS category_id,
            GROUP_CONCAT(c2.`name` ORDER BY comon_article_category_path.level SEPARATOR \'&nbsp;&nbsp;&gt;&nbsp;&nbsp;\') AS name')
            ->get()->keyBy('id')->toArray();
    }

    public function rebuild($pid = 0) {
        if(!$pid){
            self::truncate();
        }
        $levelData = ArticleCategory::where('pid',$pid)->get();
        foreach ($levelData as $val){
            self::where('article_category_id',$val->id)->delete();
            $level = 0;
            $levelPathData = self::where('article_category_id',$val->pid)->orderBy('level','ASC')->get();
            $data = [];
            foreach ($levelPathData as $v){
                $data[] = ['article_category_id' => $val->id,'path_id' =>$v->path_id,'level'=>$level];
                $level++;
            }
            $data[] = ['article_category_id' => $val->id,'path_id' =>$val->id,'level'=>$level];
            self::insert($data);
            $this->rebuild($val->id);
        }
    }
}
