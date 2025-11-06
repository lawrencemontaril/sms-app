<?php
namespace App\Observers;

use App\Models\Supply;
use App\Models\User;
use App\Notifications\LowStockNotification;
use App\Notifications\NoStockNotification;

class SupplyObserver
{
    public function saving(Supply $supply): void
    {
        $originalQuantity = $supply->getOriginal('quantity');
        $originalReorderLevel = $supply->getOriginal('reorder_level');

        // Determine if it just crossed to "no stock"
        if ($originalQuantity > 0 && $supply->quantity == 0) {
            $this->notifyProcurement(new NoStockNotification($supply));
        }

        // Determine if it just crossed to "low stock"
        if (
            $originalQuantity > $originalReorderLevel &&
            $supply->quantity <= $supply->reorder_level &&
            $supply->quantity > 0
        ) {
            $this->notifyProcurement(new LowStockNotification($supply));
        }
    }

    protected function notifyProcurement($notification): void
    {
        $procurementOfficers = User::role('procurement')->get();

        foreach ($procurementOfficers as $officer) {
            $officer->notify($notification);
        }
    }
}
