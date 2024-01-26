<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItemInfo extends Model
{
    protected $table = "order_item_info";
    protected $primaryKey = 'order_item_info ';

    // Define relationship with Order model
    public function order()
    {
        return $this->belongsTo(Order::class, 'oii_order_id', 'order');
    }

    // Define relationship with HostingerProduct model
    public function hostingerProduct()
    {
        return $this->belongsTo(HostingerProduct::class, 'oii_item_sku', 'SKU');
    }

}
