<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Source;
use App\Models\Sub_source;
use App\Models\Order;
use App\Models\HostingerProduct;
use ConsoleTVs\Charts\Facades\Charts;
class ChartController extends Controller
{
    public function index(){

        $sub_sources = '';
        $orders ='';
        $sources = Source::all();
        $subSources ='';
    
    $category = DB::table('hostinger_products')->select('ProductType')->distinct()->where('ProductType', '!=', '')->get();
    $subSources = Sub_source::get(['sub_source.sub_source','ss_name as sub_name']);

// dd($category);
        return view("chart",compact('sources','sub_sources','orders','subSources','category'));
    }


    public function getSubSources($sourceId)
    {
      $subSources = $subSources = Sub_Source::where('ss_source', $sourceId)
      ->select(DB::raw('CASE WHEN ss_map_name IS NOT NULL THEN ss_map_name ELSE ss_name END AS name'),'sub_source.sub_source as sub_name')
      ->get();
      return response()->json($subSources);
    }


    public function test(){
        return view("test");
    }

    public function test1(){
        $sources = DB::table("source")->get();
        return view("test1",compact("sources"));
    }
}
