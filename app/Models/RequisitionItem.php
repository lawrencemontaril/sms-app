<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\DB;

class RequisitionItem extends Model
{
    /*
    | ------------
    |  Properties
    | ------------
    */
    protected $fillable = [
        'requisition_id',
        'supply_id',
        'quantity',
    ];

    /*
    | ---------------
    |  Relationships
    | ---------------
    */
    public function requisition()
    {
        return $this->belongsTo(Requisition::class);
    }

    public function supply()
    {
        return $this->belongsTo(Supply::class);
    }

    /*
    | -----------
    |  Accessors
    | -----------
    */
    protected function estimatedCost(): Attribute
    {
        return Attribute::get(
            fn () => DB::raw('unit_cost * quantity')
        );
    }
}
