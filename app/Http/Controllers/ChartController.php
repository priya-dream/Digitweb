<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ChartController extends Controller
{
    public function index(){
        $sources = DB::table("source")->get();
        return view("chart",compact("sources"));
    }

    public function test(){
        return view("test");
    }
}
