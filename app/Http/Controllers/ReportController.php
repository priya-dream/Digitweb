<?php

namespace App\Http\Controllers;

use App\Models\HostingerProduct;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\OrderItemInfo;
use DB;

class ReportController extends Controller
{
    public function index1(){
        $result = HostingerProduct::
        //select('ProductType')
       // ->groupby('ProductType')
       limit(5)->get();
       dd($result);
      
      
        // $result = HostingerProduct::
        // groupBy('hostinger_products.ProductType')
        // ->get();
// dd($result);
        $data = [];

        foreach( $result as $row ){           
            $category_name = $row->ProductType;
            $qty = $row->orderItemInfo->oii_item_quantity ?? 0;
            // $revenue = $row->orderItemInfo->oii_item_price;
            //  dd($category_name);
          

            // if (!isset($data[$category_name])) {
            //     $data[$category_name] = [
            //         'qty' => 0,
            //     ];
            // }
        
        //    $data[$qty]['qty'] += $qty;
            //$source_data[$source]['avg_thir'] = $source_data[$source]['qty_thir'] / count($sales_view_all->where('order.subSource.Source.source_name', $source));
            
        }
        // dd($data);
        dd($qty);
    
            return view('report',compact('result'));
    }


    public function index(){
        // $result = OrderItemInfo::with('order.hostingerProduct')
        //     ->selectRaw("SUM(order_item_info.oii_item_quantity) as qty , SUM(order_item_info.oii_order_id) as no_of_products , SUM(order_item_info.oii_item_price) as revenue")
        //     // ->selectRaw("SUM(order_item_info.oii_item_quantity) as qty,hostinger_products.ProductType as category_name,  SUM(order_item_info.oii_item_price) as revenue")
        //     //->groupBy('category_name')
        //     ->get(['qty', 'category_name', 'revenue','no_of_products']);

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

             return view('report',compact('result'));
    }
}
