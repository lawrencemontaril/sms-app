<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\SupplyRequestObserver;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy([SupplyRequestObserver::class])]
class SupplyRequest extends Model
{
    /*
    | ------------
    |  Properties
    | ------------
    */
    protected $fillable = [
        'department_id',
        'user_id',
        'subject',
        'message',
        'status',
        'approved_at',
    ];

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

    public function supplyRequestItems(): HasMany
    {
        return $this->hasMany(SupplyRequestItem::class);
    }

    /*
    | -----------
    |  Accessors
    | -----------
    */
    protected function totalCost(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->supplyRequestItems->sum('cost')
        );
    }
}
