<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\SupplyRequestCreated;
use Illuminate\Support\Facades\DB;
use App\Models\SupplyRequest;
use App\Models\SupplyRequestItem;
use App\Models\Supply;

class SupplyRequestService
{
    public function store(string $subject, string|null $message, array $supplyRequestItems)
    {
        DB::transaction(function () use ($subject, $message, $supplyRequestItems) {
            $supplyRequest = SupplyRequest::create([
                'subject' => $subject,
                'message' => $message,
            ]);

            foreach ($supplyRequestItems as $item) {
                $supply = Supply::findOrFail($item['supply_id']);

                if ($item['quantity'] > $supply->quantity) {
                    throw new \Exception("Insufficient quantity for supply ID {$supply->id}");
                }

                SupplyRequestItem::create([
                    'supply_request_id' => $supplyRequest->id,
                    'supply_id' => $item['supply_id'],
                    'quantity' => $item['quantity'],
                ]);
            }

            $admins = User::role('procurement')->get();
            foreach ($admins as $admin) {
                $admin->notify(new SupplyRequestCreated(auth()->user(), $supplyRequest->id));
            }
        });
    }

    public function approve(SupplyRequest $supplyRequest)
    {
        $supplyRequestItems = $supplyRequest->supplyRequestItems;

        foreach($supplyRequestItems as $supplyRequestItem) {
            $supply = Supply::findOrFail($supplyRequestItem->supply_id);

            if ($supplyRequestItem->quantity > $supply->quantity) {
                throw new \Exception("Insufficient quantity for supply ID {$supply->id}");
            }

            $supply->quantity -= $supplyRequestItem->quantity;
            $supply->save();
        }

        $supplyRequest->status = 'approved';
        $supplyRequest->save();
    }

    public function reject(SupplyRequest $supplyRequest)
    {
        $supplyRequest->status = 'rejected';
        $supplyRequest->save();
    }
}
