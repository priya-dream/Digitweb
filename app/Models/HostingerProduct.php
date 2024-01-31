<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class HostingerProduct extends Model
{
    use HasFactory;

    protected $table = "hostinger_products";
    protected $primaryKey = 'ProductID';

    // Define relationship with OrderItemInfo model
    public function orderItemInfo()
    {
        return $this->hasMany(OrderItemInfo::class, 'oii_item_sku', 'SKU');
    }

    public function scopeWithCustomCount($query)
    {
        return $query->withsum([
            'orderItemInfo as no_of_products' => function ($query) {
                $query->select(DB::raw('SUM(oii_order_id) as aggregate'))->groupBy('oii_order_id');
            },
            'orderItemInfo as qty' => function ($query) {
                $query->select(DB::raw('SUM(oii_item_quantity) as aggregate'))->groupBy('oii_item_quantity');
            },
            'orderItemInfo as revenue' => function ($query) {
                $query->select(DB::raw('SUM(oii_item_price) as aggregate'))->groupBy('oii_item_price');
            }
        ]);
    }

    
    // protected $connection = 'mysql';
    // protected $table = 'hostinger_products';
    // protected $primaryKey = 'ProductID';
    // public $timestamps = false;
    // // public $connection = 'digit_web_hostinger';

	// protected $fillable = [
	// 	'SKU',
    //     'mappingsku',
    //     'Quantity',
    //     'germanInventory',
    //     'duis_de_invent',
    //     'netherland',
    //     'france',
    //     'canada'
	// ];
}