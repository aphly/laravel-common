<?php

namespace Aphly\LaravelCommon\Models;

use Aphly\Laravel\Models\Menu;
use Aphly\Laravel\Models\Module as Module_base;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Module extends Module_base
{
    public $dir = __DIR__;

    public function install($module_id){
        parent::install($module_id);
        $path = storage_path('app/private/common_init.sql');
        if(file_exists($path)){
            DB::unprepared(file_get_contents($path));
        }

        $menu = Menu::create(['name' => '基础管理','route' =>'','pid'=>0,'type'=>1,'module_id'=>$module_id,'sort'=>20]);
        if($menu){
            $menu2 = Menu::create(['name' => '用户管理','route' =>'','pid'=>$menu->id,'type'=>1,'module_id'=>$module_id,'sort'=>20]);
            if($menu2){
                $data=[];
                $data[] =['name' => '用户','route' =>'common_admin/user/index','pid'=>$menu2->id,'type'=>2,'module_id'=>$module_id,'sort'=>0];
                $data[] =['name' => '用户组','route' =>'common_admin/group/index','pid'=>$menu2->id,'type'=>2,'module_id'=>$module_id,'sort'=>0];
                $data[] =['name' => '用户组订单','route' =>'common_admin/user_group_order/index','pid'=>$menu2->id,'type'=>2,'module_id'=>$module_id,'sort'=>0];
                $data[] =['name' => '积分价格','route' =>'common_admin/credit_price/index','pid'=>$menu2->id,'type'=>2,'module_id'=>$module_id,'sort'=>0];
                $data[] =['name' => '积分订单','route' =>'common_admin/user_credit_order/index','pid'=>$menu2->id,'type'=>2,'module_id'=>$module_id,'sort'=>0];
                $data[] =['name' => '积分记录','route' =>'common_admin/user_credit_log/index','pid'=>$menu2->id,'type'=>2,'module_id'=>$module_id,'sort'=>0];
                $data[] =['name' => '地址','route' =>'common_admin/user_address/index','pid'=>$menu2->id,'type'=>2,'module_id'=>$module_id,'sort'=>0];
                DB::table('admin_menu')->insert($data);
            }
            $data=[];
            $data[] =['name' => '链接管理','route' =>'common_admin/links/index','pid'=>$menu->id,'type'=>2,'module_id'=>$module_id,'sort'=>0];
            DB::table('admin_menu')->insert($data);
            $menu22 = Menu::create(['name' => '文章管理','route' =>'','pid'=>$menu->id,'type'=>1,'module_id'=>$module_id,'sort'=>0]);
            if($menu22){
                $data=[];
                $data[] =['name' => '文章列表','route' =>'common_admin/news/index','pid'=>$menu22->id,'type'=>2,'module_id'=>$module_id,'sort'=>0];
                $data[] =['name' => '文章分类','route' =>'common_admin/news_category/index','pid'=>$menu22->id,'type'=>2,'module_id'=>$module_id,'sort'=>0];
                DB::table('admin_menu')->insert($data);
            }
            $menu21 = Menu::create(['name' => '其他设置','route' =>'','pid'=>$menu->id,'type'=>1,'module_id'=>$module_id,'sort'=>0]);
            if($menu21){
                $data=[];
                $data[] =['name' => '国家','route' =>'common_admin/country/index','pid'=>$menu21->id,'type'=>2,'module_id'=>$module_id,'sort'=>0];
                $data[] =['name' => '地区','route' =>'common_admin/zone/index','pid'=>$menu21->id,'type'=>2,'module_id'=>$module_id,'sort'=>0];
                $data[] =['name' => '货币','route' =>'common_admin/currency/index','pid'=>$menu21->id,'type'=>2,'module_id'=>$module_id,'sort'=>0];
                $data[] =['name' => 'Geo','route' =>'common_admin/geo/index','pid'=>$menu21->id,'type'=>2,'module_id'=>$module_id,'sort'=>0];
                $data[] =['name' => '订阅','route' =>'common_admin/subscribe/index','pid'=>$menu21->id,'type'=>2,'module_id'=>$module_id,'sort'=>0];
                DB::table('admin_menu')->insert($data);
            }
        }

        $menuData = Menu::where(['module_id'=>$module_id])->get();
        $data=[];
        foreach ($menuData as $val){
            $data[] =['role_id' => 1,'menu_id'=>$val->id];
        }
        DB::table('admin_role_menu')->insert($data);

        $data=[];
        $data[] =['id'=>1,'name' => 'Default Member','sort'=>0,'price'=>0];
        $data[] =['id'=>2,'name' => 'Vip Member','sort'=>0,'price'=>5];
        DB::table('common_group')->insert($data);

        $data=[];
        $data[] =['name' => '签到送积分','type' =>'point','key'=>'checkin','value'=>100,'module_id'=>$module_id];
        DB::table('admin_config')->insert($data);
        return 'install_ok';
    }

    public function uninstall($module_id){
        parent::uninstall($module_id);
        Schema::dropIfExists('common_group');
        Schema::dropIfExists('common_country');
        Schema::dropIfExists('common_zone');
        Schema::dropIfExists('common_currency');
        return 'uninstall_ok';
    }


}
