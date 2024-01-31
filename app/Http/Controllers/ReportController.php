<?php

namespace App\Http\Controllers;

use App\Models\HostingerProduct;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\OrderItemInfo;
use DB;
use Carbon\Carbon;
class ReportController extends Controller
{
    

    public function index(){
        $date_thir = Carbon::today()->subDays(30);

        $source = 'AMAZON';
        $getGroupedSku = OrderItemInfo::with(['orderFortests.subSourceForTest.sourceForTest', 'HostingerProductsForTest'])
        ->selectraw('oii_order_id, oii_item_sku')
        // ->whereHas('orderFortests', function ($query) use ($date_thir) {
        //     $query->where('order_date', '>=', $date_thir);
        // })
        // ->whereHas('orderFortests.subSourceForTest.sourceForTest', function ($query) use ($source) {
        //     $query->where('source.source_name', '=', $source);
        // })
        ->groupby('oii_item_sku')
        ->limit(100)
        ->get();
    
    $test = $getGroupedSku->groupBy('HostingerProductsForTest.ProductType');
    

dd($getGroupedSku);


// $result = OrderItemInfo::with('hostingerProduct')
//     ->selectR('oii_order_id', 'oii_item_quantity', 'oii_item_sku')
//     ->limit(20)
//     ->get();
//             dd($result);


        // DB::enableQueryLog();

        // $result = HostingerProduct::with([
        //     'orderItemInfo' => function ($query) {
        //         $query->selectRaw('oii_item_sku, SUM(oii_item_quantity) as qty, SUM(oii_item_price) as revenue, SUM(oii_order_id) as no_of_products')
        //             ->groupBy('oii_item_sku');
        //     }
        // ])
        //     ->select('ProductType')
        //     // ->whereHas('orderItemInfo.order', function ($query) {
        //     //     $query->whereBetween('order_date', ['2023-02-07', '2023-02-09']);
        //     // })
        //     ->limit(50)
        //     ->get();
        //     $result1 = $result->groupBy('ProductType');

            // dd(DB::getQueryLog());
        

            

        // $result = OrderItemInfo::with([
        //     'hostingerProduct' => function ($query) {
        //         // $query->selectRaw('SUM(oii_item_quantity) as qty');
        //     },
        //     'order' => function ($query) {
        //         //
        //     }
        // ])
        // ->select(DB::raw('SUM(order_item_info.oii_item_quantity) as qty,SUM(order_item_info.oii_order_id) as no_of_products,SUM(order_item_info.oii_item_price) as revenue'))
        // ->addselect(DB::raw('(SELECT GROUP_CONCAT(hostinger_products.ProductType) FROM hostinger_products WHERE order_item_info.oii_item_sku = hostinger_products.SKU) as category_name'))
        // ->addSelect(DB::raw('(SELECT `order`.order_date FROM `order` WHERE order_item_info.oii_order_id = `order`.order) as date1'))
        // // ->addSelect(DB::raw('(SELECT SUM(order_item_info.oii_item_quantity) FROM order_item_info WHERE order_item_info.oii_item_sku = hostinger_products.SKU) as qty'))
        // // ->addSelect(DB::raw('(SELECT SUM(order_item_info.oii_item_price) FROM order_item_info WHERE order_item_info.oii_item_sku = hostinger_products.SKU) as revenue'))
        // // ->addSelect(DB::raw('(SELECT SUM(order_item_info.oii_order_id) FROM order_item_info WHERE order_item_info.oii_order_id = order.order) as no_of_products'))
        // ->groupBy('category_name','order_item_info.oii_order_id')
        // ->having(DB::raw('DATE(date1)'), '>=', '2023-02-07')
        // ->having(DB::raw('DATE(date1)'), '<=', '2023-02-09')
        // // ->whereBetween(DB::raw('DATE(order_date)'), ['2023-02-07', '2023-02-09'])
        //     // $query->selectRaw('SUM(oii_order_id) as no_of_products');
            
        // ->limit(5)
        // ->get();
        // $result1 = $result->groupBy('category_name');
        // dd($result1);



        // $result = HostingerProduct::with([
        //     'orderItemInfo' => function ($query) {
        //         // $query->selectRaw('SUM(oii_item_quantity) as qty');
        //     }
        // ])
        //     ->select('ProductType')
        //     ->addSelect(DB::raw('(SELECT SUM(order_item_info.oii_item_quantity) FROM order_item_info WHERE order_item_info.oii_item_sku = hostinger_products.SKU) as qty'))
        //     ->addSelect(DB::raw('(SELECT SUM(order_item_info.oii_item_price) FROM order_item_info WHERE order_item_info.oii_item_sku = hostinger_products.SKU) as revenue'))
        //     // ->addSelect(DB::raw('(SELECT SUM(order_item_info.oii_order_id) FROM order_item_info WHERE order_item_info.oii_order_id = order_item_info.oii_order_id) as no_of_products')) // Adjust this line
        //     ->groupBy('ProductType', 'hostinger_products.SKU') // Adjust this line
        //     ->limit(5)
        //     ->get();
        
        // $result1 = $result->groupBy('ProductType');

        // dd($result1);


        




        // $result = DB::table('order_item_info')
        //         ->select(DB::raw('SUM(order_item_info.oii_item_quantity) as qty,
        //                         SUM(order_item_info.oii_order_id) as no_of_products,
        //                         SUM(order_item_info.oii_item_price) as revenue,
        //                         hostinger_products.ProductType as category_name,
        //                         LAG(SUM(order_item_info.oii_item_price)) OVER (ORDER BY order.order_date) as prev_revenue,
        //                         LAG(SUM(order_item_info.oii_item_quantity)) OVER (ORDER BY order.order_date) as prev_qty,
        //                         (SUM(order_item_info.oii_item_price) - LAG(SUM(order_item_info.oii_item_price)) OVER (ORDER BY order.order_date)) / LAG(SUM(order_item_info.oii_item_price)) OVER (ORDER BY order.order_date) * 100 as revenue_trend_percentage,
        //                         (SUM(order_item_info.oii_item_quantity) - LAG(SUM(order_item_info.oii_item_quantity)) OVER (ORDER BY order.order_date)) / LAG(SUM(order_item_info.oii_item_quantity)) OVER (ORDER BY order.order_date) * 100 as qty_trend_percentage'))
        //         ->leftJoin('hostinger_products', 'hostinger_products.SKU', '=', 'order_item_info.oii_item_sku')
        //         ->leftJoin('order', 'order.order', '=', 'order_item_info.oii_order_id')
        //         ->where(DB::raw('DATE(order.order_date)'), '=', '2023-02-07')
        //         ->groupBy('category_name')
        //         ->get();

                // dd($result);

        //     $revenueTrend = [];
        //     $previousRevenue = null;

        // foreach ($result as $row) {
        //     $revenueTrend[] = [
        //         'qty' => $row->qty,
        //         'category_name' => $row->category_name,
        //         'revenue' => $row->revenue,
        //         'revenue_trend_percentage' => $previousRevenue ? (($row->revenue - $previousRevenue) / $previousRevenue) * 100 : null,
        //     ];

        //     $previousRevenue = $row->revenue;
        //     dd($revenueTrend);
        // }

             return view('report',compact('result1'));
    }
}
