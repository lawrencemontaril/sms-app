<?php

namespace App\Observers;

use App\Models\SupplyRequest;
use App\Notifications\SupplyRequestApproved;
use App\Notifications\SupplyRequestRejected;

class SupplyRequestObserver
{
    public function creating(SupplyRequest $supplyRequest): void
    {
        $supplyRequest->user_id = auth()->user()->id;
        $supplyRequest->department_id = auth()->user()->department->id;
    }

    public function saving(SupplyRequest $supplyRequest): void
    {
        if ($supplyRequest->status == 'approved') {
            $supplyRequest->approved_at = now();

            $supplyRequest->user->notify(new SupplyRequestApproved($supplyRequest));
        }

        if ($supplyRequest->status == 'rejected') {
            $supplyRequest->user->notify(new SupplyRequestRejected($supplyRequest));
        }
    }
}
