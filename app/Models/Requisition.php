<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\RequisitionObserver;
use Illuminate\Database\Eloquent\Model;
use App\Enums\RequsitionStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\DB;

#[ObservedBy([RequisitionObserver::class])]
class Requisition extends Model
{
    /*
    | ------------
    |  Properties
    | ------------
    */
    public const CREATED_AT = 'requested_at';

    protected $fillable = [
        // 'department_id',
        // 'user_id',
        'subject',
        'message',
        // 'status',
        'remarks',
        // 'approved_at',
    ];

    /*
    | -------
    |  Casts
    | -------
    */
    protected function casts(): array
    {
        return [
            'status' => RequsitionStatus::class,
        ];
    }

    /*
    | ---------------
    |  Relationships
    | ---------------
    */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function requisitionSupplies(): HasMany
    {
        return $this->hasMany(RequisitionSupply::class);
    }

    public function requisitionApprovals(): HasMany
    {
        return $this->hasMany(RequisitionSupply::class);
    }

    public function purchaseOrders(): HasMany
    {
        return $this->hasMany(PurchaseOrder::class);
    }

    /*
    | -----------
    |  Accessors
    | -----------
    */
    protected function estimatedTotalCost(): Attribute
    {
        return Attribute::get(
            fn () => $this->requisitionSupplies()->sum(DB::raw('unit_cost * quantity'))
        );
    }
}
