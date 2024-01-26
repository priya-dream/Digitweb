<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItemInfo extends Model
{
    protected $table = "order_item_info";
    
    public function order() {
        return $this->belongsTo(Order::class, 'oii_order_id', 'order'); 
    }

    public function hostingerProduct() {
        return $this->belongsTo(HostingerProduct::class, 'oii_item_sku', 'SKU'); 
    }

}
