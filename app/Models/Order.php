<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'scanned_at',
        'mobile',
        'city',
        'state',
        'address',
        'pincode',
        'product',
        'amount',
        'barcode',
        'status',
        'update_by',
    ];
}
