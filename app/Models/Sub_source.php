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
}
