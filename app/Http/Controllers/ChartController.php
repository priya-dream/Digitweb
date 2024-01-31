<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Source;
use App\Models\Sub_source;
use App\Models\Order;
use App\Models\HostingerProduct;
use App\Models\OrderItemInfo;
use ConsoleTVs\Charts\Facades\Charts;
use Carbon\Carbon;
class ChartController extends Controller
{
    public function index(Request $request){

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
    //   dd($subSources);
      return response()->json($subSources);
    }


    public function test(){
        return view("test");
    }

    public function test1(){
        $sources = DB::table("source")->get();
        return view("test1",compact("sources"));
    }

    public function formResult(Request $request){

        $sub_sources = '';
        $orders ='';
        $sources = Source::all();
        $subSources ='';
    
    $category1 = DB::table('hostinger_products')->select('ProductType')->distinct()->where('ProductType', '!=', '')->get();
    $subSources = Sub_source::get(['sub_source.sub_source','ss_name as sub_name']);

        // have 1 blade file .in blade file there is a form, when I click submit button need to display two blade file in the same page in laravel
        $result = DB::table('order_item_info')
            ->select(DB::raw('SUM(order_item_info.oii_item_quantity) as qty,
                            SUM(order_item_info.oii_order_id) as no_of_products,
                            SUM(order_item_info.oii_item_price) as revenue,
                            hostinger_products.ProductType as category_name,
                            LAG(SUM(order_item_info.oii_item_price)) OVER (ORDER BY order.order_date) as prev_revenue,
                            LAG(SUM(order_item_info.oii_item_quantity)) OVER (ORDER BY order.order_date) as prev_qty,
                            (SUM(order_item_info.oii_item_price) - LAG(SUM(order_item_info.oii_item_price)) OVER (ORDER BY order.order_date)) / LAG(SUM(order_item_info.oii_item_price)) OVER (ORDER BY order.order_date) * 100 as revenue_trend_percentage,
                            (SUM(order_item_info.oii_item_quantity) - LAG(SUM(order_item_info.oii_item_quantity)) OVER (ORDER BY order.order_date)) / LAG(SUM(order_item_info.oii_item_quantity)) OVER (ORDER BY order.order_date) * 100 as qty_trend_percentage'))
            ->leftJoin('hostinger_products', 'hostinger_products.SKU', '=', 'order_item_info.oii_item_sku')
            ->leftJoin('order', 'order.order', '=', 'order_item_info.oii_order_id')
            ->where(DB::raw('DATE(order.order_date)'), '=', '2023-02-07')
            ->groupBy('category_name')
            ->get();

        //................................................................

    $startDate = $request->input('from');
    $endDate = $request->input('to');

    $source = DB::table('source')->select('source_name')->where('source',$request->input('source'))->first();
    $sub_source = DB::table('sub_source')->select('ss_name')->where('sub_source',$request->input('sub_source'))->first();

    $category = $request->input('category');
    $type = $request->input('type');
    $range = $request->input('range');

    $s_date = Carbon::parse($startDate);
    $e_date = Carbon::parse($endDate);

    $diff = $s_date->diffInDays($e_date);

    $today_date = Carbon::now()->toDateString(); 
    $day_30 = Carbon::now()->addDays(-30)->toDateString();
    $day_15 = Carbon::now()->addDays(-15)->toDateString();
    $day_7 = Carbon::now()->addDays(-7)->toDateString();
    // dd($day_15);
  
    // Get data for the current date range
    $currentYearData = Order::whereBetween('order_date', [$startDate, $endDate])
        ->leftjoin('order_item_info', 'order.order', '=', 'order_item_info.oii_order_id')
        ->leftjoin('sub_source', 'sub_source.sub_source', '=', 'order.order_sub_source')
        ->leftjoin('source', 'source.source', '=', 'sub_source.ss_source')
        ->leftJoin('hostinger_products', 'hostinger_products.SKU', '=', 'order_item_info.oii_item_sku')
        ->selectRaw("DATE(order.order_date) as date, SUM(order_item_info.oii_item_quantity) as quantity")
        ->groupBy('date')
        ->orderBy('date')
        ->pluck('quantity', 'date');

    // Get data for the previous year's date range
    $previousYearStartDate = Carbon::parse($startDate)->subYear()->format('Y-m-d');
    $previousYearEndDate = Carbon::parse($endDate)->subYear()->format('Y-m-d');
    // dd($today_date);

    $previousYearData = Order::whereBetween('order_date', [$previousYearStartDate, $previousYearEndDate])
        ->leftjoin('order_item_info', 'order.order', '=', 'order_item_info.oii_order_id')
        ->leftjoin('sub_source', 'sub_source.sub_source', '=', 'order.order_sub_source')
        ->leftjoin('source', 'source.source', '=', 'sub_source.ss_source')
        ->leftJoin('hostinger_products', 'hostinger_products.SKU', '=', 'order_item_info.oii_item_sku')
        ->selectRaw("DATE(order.order_date) as date, SUM(order_item_info.oii_item_quantity) as quantity")
        ->groupBy('date')
        ->orderBy('date')
        ->pluck('quantity', 'date');

        if ($source) {
            $currentYearData->where('source.source', $source);
            $previousYearData->where('source.source',$source);
        }
        if ($sub_source) {
            $currentYearData->where('sub_source.sub_source', $sub_source);
            $previousYearData->where('sub_source.sub_source', $sub_source);
        }
        if ($category) {
            $currentYearData->where('hostinger_products.ProductType', $category);
            $previousYearData->where('hostinger_products.ProductType', $category);
        }
        if ($range) {
            if($range == 'Last 30 days') {
            $currentYearData->whereBetween('order_date.', [$today_date, $day_30]);
            $previousYearData->whereBetween('order_date', [$today_date, $day_30]);
            }
            elseif($range == 'Last 15 days') {
                $currentYearData->whereBetween('order_date', [$today_date, $day_15]);
                $previousYearData->whereBetween('order_date', [$today_date, $day_15]);
            }
            elseif($range == 'Last 7 days') {
                $currentYearData->whereBetween('order_date.', [$today_date, $day_7]);
                $previousYearData->whereBetween('order_date', [$today_date, $day_7]);
            }
            else{
                $currentYearData->whereBetween('order_date', [$previousYearStartDate, $previousYearEndDate]);
                $previousYearData->whereBetween('order_date', [$previousYearStartDate, $previousYearEndDate]);
            }
        }
// dd($currentYearData);

            function ordinal($number) {
                $suffix = '';
                if ($number % 100 >= 11 && $number % 100 <= 13) {
                    $suffix = 'th';
                } else {
                    switch ($number % 10) {
                        case 1:
                            $suffix = 'st';
                            break;
                        case 2:
                            $suffix = 'nd';
                            break;
                        case 3:
                            $suffix = 'rd';
                            break;
                        default:
                            $suffix = 'th';
                            break;
                    }
                }
                return $number . $suffix;
            }
            $weekLabels = [];
            $uniqueWeeks = [];
            $monthLabels = [];
            $uniqueMonths = [];

                while ($s_date->lte($e_date)) {
                    $weekNumber = $s_date->weekOfYear;
                    $formattedWeek = ordinal($weekNumber) . ' week';
                
                    // Ensure the week label is unique
                    while (in_array($formattedWeek, $weekLabels)) {
                        $weekNumber++;
                        $formattedWeek = ordinal($weekNumber) . ' week';
                    }
                
                    $weekLabels[] = $formattedWeek;
                    $s_date->addWeek(); // Move to the next week
                }
                while ($s_date->lte($e_date)) {
                    $monthNumber = $s_date->monthOfYear;
                    $formattedMonth = ordinal($monthNumber) . ' month';
                
                    // Ensure the week label is unique
                    while (in_array($formattedMonth, $monthLabels)) {
                        $monthNumber++;
                        $formattedMonth = ordinal($monthNumber) . ' month';
                    }
                
                    $monthLabels[] = $formattedMonth;
                    $s_date->addMonth(); // Move to the next month
                }
        
        // $data = [
        //     'result' => $result, 
        //     'startDate' => $startDate,
        //     'endDate' => $endDate,
        //     'currentYearData' => $currentYearData,
        //     'previousYearData' => $previousYearData,
        //     'weekLabels' => $weekLabels,
        //     'monthLabels' => $monthLabels,
        //     'type' => $type,
        //     'diff' => $diff,
        // ];

        // Render the views
        // return response()->json(['view' => $view]);
        // $view = view('test1', compact('result','startDate','endDate','currentYearData','previousYearData','previousYearData','weekLabels','monthLabels','type','diff'))->render();

        
        return view('/chart', compact('sources','sub_sources','orders','subSources','category','category1','result','startDate','endDate','currentYearData','previousYearData','previousYearData','weekLabels','monthLabels','type','diff','range','source','sub_source'));
        //
    }
}
