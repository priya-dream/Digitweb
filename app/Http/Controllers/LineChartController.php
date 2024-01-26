<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderItemInfo;
use DB;
use Carbon\Carbon;


class LineChartController extends Controller
{
    public function lineChart(Request $request)
    {
        // $from = $request->input('from');
        // $to = $request->input('to');
        $from = "2023-02-01";
        $to = "2023-02-04";

    $fromDate = Carbon::parse($from);
    $toDate = Carbon::parse($to);

    $previousYearFromDate = $fromDate->copy()->subYear();
    $previousYearToDate = $toDate->copy()->subYear();

    $currentYearDateRange = $fromDate->format('Y-m-d') . ' - ' . $toDate->format('Y-m-d');
    $previousYearDateRange = $previousYearFromDate->format('Y-m-d') . ' - ' . $previousYearToDate->format('Y-m-d');

    $result = DB::select("
        SELECT CAST(`order`.order_date AS DATE) as date,
            SUM(order_item_info.oii_item_quantity) AS order_qty
        FROM `order`
        LEFT JOIN order_item_info ON order_item_info.oii_order_id = `order`.order_id
        LEFT JOIN sub_source ON sub_source.sub_source = `order`.order_sub_source
        LEFT JOIN source ON source.source = sub_source.ss_source
        WHERE DATE(`order`.order_date) BETWEEN '$previousYearFromDate' AND '$previousYearToDate'
        GROUP BY CAST(`order`.order_date AS DATE)
    ");

    $result1 = DB::select("
        SELECT CAST(`order`.order_date AS DATE) as date,
            SUM(order_item_info.oii_item_quantity) AS order_qty
        FROM `order`
        LEFT JOIN order_item_info ON order_item_info.oii_order_id = `order`.order_id
        LEFT JOIN sub_source ON sub_source.sub_source = `order`.order_sub_source
        LEFT JOIN source ON source.source = sub_source.ss_source
        WHERE DATE(`order`.order_date) BETWEEN '$from' AND '$to'
        GROUP BY CAST(`order`.order_date AS DATE)
    ");

    $x_label_query = DB::select("
        WITH RECURSIVE date_series AS (
            SELECT '$from' AS date
            UNION
            SELECT DATE_ADD(date, INTERVAL 1 DAY)
            FROM date_series
            WHERE DATE_ADD(date, INTERVAL 1 DAY) <= '$to'
        )
        SELECT date FROM date_series
    ");

    // Initialize empty arrays for x_values
// Simulating the data for Label 1 (current year)
$result = [
    (object)['date' => '2023-02-01', 'order_qty' => 10],
    (object)['date' => '2023-02-02', 'order_qty' => 15],
    // Add more dates as needed
];

$x_values[$currentYearDateRange] = [];
foreach ($result as $val) {
    $x_values[$currentYearDateRange][$val->date] = $val->order_qty;
}

// Simulating the data for Label 2 (previous year)
$result1 = [
    (object)['date' => '2022-02-01', 'order_qty' => 20],
    (object)['date' => '2022-02-02', 'order_qty' => 25],
    // Add more dates as needed
];

$x_values[$previousYearDateRange] = [];
foreach ($result1 as $val) {
    $x_values[$previousYearDateRange][$val->date] = $val->order_qty;
}

$x_labels = [$currentYearDateRange, $previousYearDateRange];


    //$x_labels = [$currentYearDateRange, $previousYearDateRange];


        // $data = "";
        // foreach($result as $val){
        //     $data.="[$val->date,$val->order_qty,65],";
        //     $x_values = [
        //         $currentYearDateRange => [$val->order_qty, 15], // Values for Label 1
        //         $previousYearDateRange => [20, 25], // Values for Label 2
        //     ];
        // }

        //$data = rtrim($data, ',');

       
       

        // $x_values = array_map(function ($label) {
        //     return $label->date;
        // }, $x_label_query);
       // return view ('test',compact('x_values','x_labels'));

        // dd($data);

// ...............................................................................................

        $sales_1_month = OrderItemInfo::select(DB::raw("sum(oii_item_quantity) as count"), DB::raw("DATE(order_date) as order_date"))
                //->where('oii_item_sku', '=', 'ENC285')
                ->join('order', 'order_item_info.oii_order_id', '=', 'order.order')
                ->whereBetween('order_date', [Carbon::now()->subMonth(1), Carbon::now()])
                // ->whereYear('order_date', date('Y'))
                ->groupBy(DB::raw("order_date"))
                ->orderBy('order_date', 'ASC')
                ->pluck('count', 'order_date');

            $label_1_month = $sales_1_month->keys(); // Extracts the keys (dates) from the collection
            $data_1_month = $sales_1_month->values();

            // $sql = $sales_1_month->toSql();
            // $res = $sales_1_month->pluck('count', 'order_date');
            // dd($sales_1_month);
    //$chartData = [10, 20, 15, 25, 30];
    return view('test', compact('label_1_month', 'data_1_month'));
    }
}
