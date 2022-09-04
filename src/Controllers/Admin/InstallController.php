<?php

namespace Aphly\LaravelCommon\Controllers\Admin;

use Aphly\LaravelAdmin\Models\Menu;
use Aphly\LaravelAdmin\Models\Role;
use Illuminate\Support\Facades\DB;

class InstallController extends Controller
{
    public $module_id = 2;

    public function install(){
        $path = storage_path('app/private/common_init.sql');
        if(file_exists($path)){
            DB::unprepared(file_get_contents($path));
        }
        $menu = Menu::create(['name' => '基础管理','url' =>'','pid'=>0,'is_leaf'=>0,'module_id'=>$this->module_id,'sort'=>20]);
        if($menu){
            $menu2 = Menu::create(['name' => '用户管理','url' =>'','pid'=>$menu->id,'is_leaf'=>0,'module_id'=>$this->module_id,'sort'=>20]);
            if($menu2){
                $data=[];
                $data[] =['name' => '用户','url' =>'/common_admin/user/index','pid'=>$menu2->id,'is_leaf'=>1,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['name' => '用户组','url' =>'/common_admin/group/index','pid'=>$menu2->id,'is_leaf'=>1,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['name' => '用户组订单','url' =>'/common_admin/user_group_order/index','pid'=>$menu2->id,'is_leaf'=>1,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['name' => '积分价格','url' =>'/common_admin/credit_price/index','pid'=>$menu2->id,'is_leaf'=>1,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['name' => '积分订单','url' =>'/common_admin/user_credit_order/index','pid'=>$menu2->id,'is_leaf'=>1,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['name' => '积分记录','url' =>'/common_admin/user_credit_log/index','pid'=>$menu2->id,'is_leaf'=>1,'module_id'=>$this->module_id,'sort'=>0];
                DB::table('admin_menu')->insert($data);
            }
            $data=[];
            $data[] =['name' => '链接管理','url' =>'/common_admin/link/index','pid'=>$menu->id,'is_leaf'=>1,'module_id'=>$this->module_id,'sort'=>0];
            $data[] =['name' => '分类管理','url' =>'/common_admin/category/index','pid'=>$menu->id,'is_leaf'=>1,'module_id'=>$this->module_id,'sort'=>0];
            $data[] =['name' => '筛选管理','url' =>'/common_admin/filter/index','pid'=>$menu->id,'is_leaf'=>1,'module_id'=>$this->module_id,'sort'=>0];
            $data[] =['name' => '文章管理','url' =>'/common_admin/news/index','pid'=>$menu->id,'is_leaf'=>1,'module_id'=>$this->module_id,'sort'=>0];
            DB::table('admin_menu')->insert($data);
            $menu21 = Menu::create(['name' => '其他设置','url' =>'','pid'=>$menu->id,'is_leaf'=>0,'module_id'=>$this->module_id,'sort'=>0]);
            if($menu21){
                $data=[];
                $data[] =['name' => '国家','url' =>'/common_admin/country/index','pid'=>$menu21->id,'is_leaf'=>1,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['name' => '地区','url' =>'/common_admin/zone/index','pid'=>$menu21->id,'is_leaf'=>1,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['name' => '货币','url' =>'/common_admin/currency/index','pid'=>$menu21->id,'is_leaf'=>1,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['name' => 'Geo','url' =>'/common_admin/geo/index','pid'=>$menu21->id,'is_leaf'=>1,'module_id'=>$this->module_id,'sort'=>0];
                DB::table('admin_menu')->insert($data);
            }
        }

        $menuData = Menu::where(['module_id'=>$this->module_id])->get();
        $data=[];
        foreach ($menuData as $val){
            $data[] =['role_id' => Role::MANAGER,'menu_id'=>$val->id];
        }
        DB::table('admin_role_menu')->insert($data);

        $data=[];
        $data[] =['id'=>1,'name' => 'Default Member','sort'=>0,'price'=>0];
        $data[] =['id'=>2,'name' => 'Vip Member','sort'=>0,'price'=>5];
        DB::table('common_group')->insert($data);

        $data=[];
        $data[] =['name' => '签到送积分','type' =>'point','key'=>'checkin','value'=>100,'module_id'=>$this->module_id];
        DB::table('admin_config')->insert($data);

        return 'install_ok';
    }
    public function uninstall(){
        $admin_menu = DB::table('admin_menu')->where('module_id',$this->module_id);
        $arr = $admin_menu->get()->toArray();
        if($arr){
            $admin_menu->delete();
            $ids = array_column($arr,'id');
            DB::table('admin_role_menu')->whereIn('menu_id',$ids)->delete();
        }

        $admin_dict = DB::table('admin_dict')->where('module_id',$this->module_id);
        $arr = $admin_dict->get()->toArray();
        if($arr){
            $admin_dict->delete();
            $ids = array_column($arr,'id');
            DB::table('admin_dict_value')->whereIn('dict_id',$ids)->delete();
        }
        DB::table('admin_config')->where('module_id',$this->module_id)->delete();

        DB::table('common_group')->truncate();
        DB::table('common_country')->truncate();
        DB::table('common_zone')->truncate();
        DB::table('common_currency')->truncate();
        return 'uninstall_ok';
    }


}
