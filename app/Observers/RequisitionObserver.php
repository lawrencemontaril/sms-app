<?php

namespace App\Observers;

use App\Models\Requisition;

class RequisitionObserver
{
    public function creating(Requisition $requisition): void
    {
        $requisition->user_id = auth()->user()->id;
        $requisition->department_id = auth()->user()->department->id;
    }

    public function saving(Requisition $requisition): void
    {
        if ($requisition->status == 'approved') {
            $requisition->approved_at = now();
        }
    }
}
