<?php

namespace App\Http\Controllers;

use App\Models\HostingerProduct;
use Illuminate\Http\Request;
use App\Models\OrderItemInfo;
class ReportController extends Controller
{
    public function index(){
        // $result = OrderItemInfo::with('order.hostingerProduct')
        //     ->selectRaw("SUM(order_item_info.oii_item_quantity) as qty , SUM(order_item_info.oii_order_id) as no_of_products , SUM(order_item_info.oii_item_price) as revenue")
        //     // ->selectRaw("SUM(order_item_info.oii_item_quantity) as qty,hostinger_products.ProductType as category_name,  SUM(order_item_info.oii_item_price) as revenue")
        //     //->groupBy('category_name')
        //     ->get(['qty', 'category_name', 'revenue','no_of_products']);

        $result = OrderItemInfo::
            // whereYear('order.order_date', date('Y'))
            leftjoin('hostinger_products', 'order_item_info.oii_item_sku', '=', 'hostinger_products.SKU')
        ->leftjoin('order', 'order.order', '=', 'order_item_info.oii_order_id')    
        ->selectRaw("SUM(order_item_info.oii_item_quantity) as qty , SUM(order_item_info.oii_order_id) as no_of_products ,
                     hostinger_products.ProductType as category_name , SUM(order_item_info.oii_item_price) as revenue")
        ->groupBy('category_name')
        ->get(['qty', 'category_name', 'revenue','no_of_products']);

        // return $result;
        // dd($result);
        return view('report',compact('result'));
    }
}
