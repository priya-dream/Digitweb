<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HostingerProduct extends Model
{
    use HasFactory;

    protected $table = "hostinger_products";
    protected $primaryKey = 'SKU';

    // Define relationship with OrderItemInfo model
    public function orderItemInfo()
    {
        return $this->hasMany(OrderItemInfo::class, 'oii_item_sku', 'SKU');
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