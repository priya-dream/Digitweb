<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItemInfo extends Model
{
    protected $table = "order_item_info";
    protected $primaryKey = 'oii_order_id';

    protected $fillable = [
        'order_item_info',
        'oii_order_id',
        'oii_order_ref_id',
        'oii_line_item_id',
        'oii_item_transaction_id',
        'oii_item_id',
        'oii_item_asin',
        'oii_product_id',
        'oii_variant_id',
        'oii_handle',
        'oii_item_sku',
        'oii_item_title',
        'oii_item_price',
        'oii_item_quantity',
        'oii_variation_status',
        'oii_item_instruction',
        'oii_item_img'
        
       

    ];

    // Define relationship with Order model
    // public function order()
    // {
    //     return $this->belongsTo(Order::class, 'oii_order_id', 'order');
    // }

    // Define relationship with HostingerProduct model
    public function hostingerProduct()
    {
        return $this->belongsTo(HostingerProduct::class, 'oii_item_sku', 'SKU');
    }

    public function orderFortests()
{
    return $this->belongsTo(Order::class, 'oii_order_id', 'order')->selectRaw('order.order,order_date,order_sub_source,order_market_place');
}
public function HostingerProductsForTest()
{
    return $this->belongsTo(HostingerProduct::class, 'oii_item_sku', 'SKU')->selectRaw('SKU,hostinger_products.ProductType');
}
}
