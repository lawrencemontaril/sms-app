<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class SupplyRequestItem extends Model
{
    /*
    | ------------
    |  Properties
    | ------------
    */
    protected $fillable = [
        'supply_request_id',
        'supply_id',
        'quantity',
    ];

    /*
    | ---------------
    |  Relationships
    | ---------------
    */
    public function supplyRequest(): BelongsTo
    {
        return $this->belongsTo(SupplyRequest::class);
    }

    public function supply(): BelongsTo
    {
        return $this->belongsTo(Supply::class);
    }

    /*
    | -----------
    |  Accessors
    | -----------
    */
    protected function cost(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->quantity * $this->supply->price
        );
    }
}
