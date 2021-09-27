<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{   
    protected $fillable = [
        'user_id',
        'email_inbox_messages',
        'email_order_messages',
        'email_borrowme_promotions',
        'email_borrowme_updates',
        'mobile_inbox_messages',
        'mobile_order_messages',
        'mobile_borrowme_promotions',
        'mobile_borrowme_updates'
    ];
}