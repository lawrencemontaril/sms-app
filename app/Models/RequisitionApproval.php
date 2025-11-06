<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\RequisitionApprovalObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy([RequisitionApprovalObserver::class])]
class RequisitionApproval extends Model
{
    /*
    | ------------
    |  Properties
    | ------------
    */
    protected $fillable = [
        'requisition_id',
        'user_id',
        'role',
        'remarks'
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
