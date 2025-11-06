<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PurchaseOrder extends Model
{
    /*
    | ------------
    |  Properties
    | ------------
    */
    protected $fillable = [
        'requisition_id',
        'supplier_id',
        'delivery_date',
        // 'delivered_at',
    ];

    /*
    | ---------------
    |  Relationships
    | ---------------
    */
    public function requisition(): BelongsTo
    {
        return $this->belongsTo(Requisition::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function purchaseOrderSupplies(): HasMany
    {
        return $this->hasMany(PurchaseOrderSupply::class);
    }
}
