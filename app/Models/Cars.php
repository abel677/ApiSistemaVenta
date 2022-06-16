<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cars extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'quantity',
        'state',
        'total',
        'id_product'
    ];
}
