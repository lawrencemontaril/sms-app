<?php

namespace App\Observers;

use App\Models\RequisitionApproval;

class RequisitionApprovalObserver
{
    public function saving(RequisitionApproval $requisitionApproval): void
    {
        if ($requisitionApproval->status == 'approved') {
            $requisitionApproval->approved_at = now();
        }
    }
}
