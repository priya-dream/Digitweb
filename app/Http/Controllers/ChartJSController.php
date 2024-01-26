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
            if($range == 'Last 15 days') {
                $currentYearData->whereBetween('order_date.', [$today_date, $day_15]);
                $previousYearData->whereBetween('order_date', [$today_date, $day_15]);
            }
            if($range == 'Last 7 days') {
                $currentYearData->whereBetween('order_date.', [$today_date, $day_7]);
                $previousYearData->whereBetween('order_date', [$today_date, $day_7]);
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
                // dd($type);
    return view('test1', compact('startDate', 'endDate', 'currentYearData', 'previousYearData','diff','weekLabels','monthLabels','type'));
}

        
        
    } 
