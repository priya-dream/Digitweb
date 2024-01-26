<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HostingerProduct extends Model
{
    use HasFactory;
    protected $table = "hostinger_products";
    protected $fillable = ['ProductType'];

    public function orderItemInfo() {
        return $this->hasOne(OrderItemInfo::class, 'oii_item_sku', 'SKU');
    }

}
