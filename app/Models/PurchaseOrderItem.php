<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    /*
    | ------------
    |  Properties
    | ------------
    */
    protected $fillable = [
        'purchase_order_id',
        'supply_id',
        'quantity',
        'unit_cost',
        // 'delivered_at',
    ];
}
