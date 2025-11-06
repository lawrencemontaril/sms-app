<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    /*
    | ------------
    |  Properties
    | ------------
    */
    protected $fillable = [
        'user_id',
        'name',
        'code'
    ];

    /*
    | ---------------
    |  Relationships
    | ---------------
    */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)
            ->withDefault();
    }
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function supplyRequests(): HasMany
    {
        return $this->hasMany(SupplyRequest::class);
    }

    public function requisitions(): HasMany
    {
        return $this->hasMany(Requisition::class);
    }
}
