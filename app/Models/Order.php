<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = "order";
    protected $primaryKey = 'order';

    // Define relationship with OrderItemInfo model
    public function orderItemInfo()
    {
        return $this->hasMany(OrderItemInfo::class, 'oii_order_id', 'order');
    }

    public function subSourceForTest()
    {
        return $this->belongsTo(Sub_source::class, 'order_sub_source', 'sub_source')->selectraw('sub_source,ss_source'); // Replace 'sub_source' with the actual foreign key in the 'sub_source' table
    }
    

}
