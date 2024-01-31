<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pdf extends Model
{
    use HasFactory;

    protected $table = "pdf_files";
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['path','address','check_address'];

}
