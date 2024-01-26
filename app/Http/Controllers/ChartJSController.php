<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use DB;
use App\Models\Order;
use App\Models\OrderItemInfo;
use Carbon\Carbon;

class ChartJSController extends Controller
{
public function index(Request $request)
{
    $startDate = $request->input('from');
    $endDate = $request->input('to');

    $source = $request->input('source');
    $sub_source = $request->input('sub_source');
    // dd($sub_source);

   

    // Get data for the current date range
    $currentYearData = Order::whereBetween('order_date', [$startDate, $endDate])
        ->leftjoin('order_item_info', 'order.order', '=', 'order_item_info.oii_order_id')
        ->leftjoin('sub_source', 'sub_source.sub_source', '=', 'order.order_sub_source')
        ->leftjoin('source', 'source.source', '=', 'sub_source.ss_source')
        ->selectRaw("DATE(order.order_date) as date, SUM(order_item_info.oii_item_quantity) as quantity")
        ->groupBy('date')
        ->orderBy('date')
        ->pluck('quantity', 'date');

    // Get data for the previous year's date range
    $previousYearStartDate = Carbon::parse($startDate)->subYear()->format('Y-m-d');
    $previousYearEndDate = Carbon::parse($endDate)->subYear()->format('Y-m-d');

    $previousYearData = Order::whereBetween('order_date', [$previousYearStartDate, $previousYearEndDate])
        ->leftjoin('order_item_info', 'order.order', '=', 'order_item_info.oii_order_id')
        ->leftjoin('sub_source', 'sub_source.sub_source', '=', 'order.order_sub_source')
        ->leftjoin('source', 'source.source', '=', 'sub_source.ss_source')
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
// dd($previousYearData);
        
    return view('test1', compact('startDate', 'endDate', 'currentYearData', 'previousYearData'));
}

        
        
    } 
