<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $appends = [
        'order_details_json',
        'billing_details_json'
    ];

    public function getOrderDetailsJsonAttribute()
    {
        return json_decode($this->order_details);
    }

    public function getBillingDetailsJsonAttribute()
    {
        return json_decode($this->billing_details);
    }

    public function order_products()
    {
        return $this->hasMany('App\Models\OrderProduct','order_id','id');
    }
}
