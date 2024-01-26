<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    protected $table = "source";
    public function subdatas()
    {
        return $this->hasMany(Sub_source::class);
    }
}
