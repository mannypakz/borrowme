<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{   
    protected $fillable = [
    	'vendor_id',
        'purchaser',
        'product_id',
        'rented',
        'bought',
        'status',
        'price',
        'order_type',
        'date_rented',
        'date_available',
    ];
}