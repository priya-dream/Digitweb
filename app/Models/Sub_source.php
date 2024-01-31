<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sub_source extends Model
{
    protected $table = "sub_source";
    public function mainData()
    {
        return $this->belongsTo(Source::class);
    }

    public function sourceForTest()
    {
        return $this->belongsTo(Source::class, 'ss_source','source')->selectraw('source,source_name');
    }
    public function HostingerProductsForTest()
{
    return $this->belongsTo(HostingerProduct::class, 'oii_item_sku', 'SKU')->selectRaw('SKU,hostinger_products.ProductType');
}
}
