<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'vendor_id',
        'category',
        'sub_category',
        'item_type',
        'item_name',
        'description',
        'item_condition',
        'age',
        'phone_code',
        'phone',
        'rental_duration_daily',
        'rental_duration_weekly',
        'rental_duration_monthly',
        'daily_aed',
        'weekly_aed',
        'monthly_aed',
        'cash_deposit',
        'available_for_sale',
        'sale_price',
        'images',
        'primary_img',
        'location_1',
        'location_2',
        'street',
        'area',
        'city',
        'neighbourhood',
        'rent_status',
        'sale_status',
        'date_rented',
        'date_available',
        'listing_type',
        'lat',
        'lng',
        'order_id',
    ];
}