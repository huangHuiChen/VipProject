<?php
namespace App\Helpers;
use Illuminate\Support\Facades\DB;

class Common{
    public function NavBar(){
        $navItems = [
            ['name' => '公告', 'link' => '/'],
            ['name' => '小遊戲獲獎查詢(測試中)', 'link' => '/testB'],
            ['name' => '庫存日結作業(勿按)', 'link' => '/testA'],
        ];

        return $navItems;
    }

}