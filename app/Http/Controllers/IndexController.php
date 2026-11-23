<?php

namespace App\Http\Controllers;
require_once app_path('Helper/Common.php');
use App\Helpers\Common;


class IndexController extends Controller
{
    public function index(){
        $Common = new Common();
        $navItems = $Common -> NavBar();

        return view('index', compact('navItems'));
    }
}
