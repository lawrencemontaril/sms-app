<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\SupplyRequest;
use App\Models\SupplyRequestItem;
use App\Models\Supply;

class AnalyticsService
{
    public function getTotalSupplies()
    {
        return Supply::count();
    }

    public function getTotalSupplyCost()
    {
        if (auth()->user()->hasAnyRole(['procurement', 'accountant'])) {
            return Supply::all()->sum('total_cost');
        }

        return SupplyRequest::with('supplyRequestItems.supply')
            ->where('user_id', auth()->user()->id)
            ->approved()
            ->get()
            ->sum('total_cost');
    }

    public function getTotalSupplyRequests()
    {
        if (auth()->user()->hasAnyRole(['procurement', 'accountant'])) {
            return SupplyRequest::count();
        }

        return auth()->user()->supplyRequests()->count();
    }

    public function getTotalApprovedSupplyRequests()
    {
        return SupplyRequest::approved()->count();
    }

    public function getTotalRejectedSupplyRequests()
    {
        return SupplyRequest::rejected()->count();
    }

    public function getSupplyRequestApprovedRejectedRatio()
    {
        if (auth()->user()->hasAnyRole(['procurement', 'accountant'])) {
            return [
                'pending' => SupplyRequest::pending()->count(),
                'approved' => SupplyRequest::approved()->count(),
                'rejected' => SupplyRequest::rejected()->count(),
            ];
        }

        return [
            'pending' => SupplyRequest::where('user_id', auth()->user()->id)->where('status', 'pending')->count(),
            'approved' => SupplyRequest::where('user_id', auth()->user()->id)->where('status', 'approved')->count(),
            'rejected' => SupplyRequest::where('user_id', auth()->user()->id)->where('status', 'rejected')->count(),
        ];
    }

    public function getSupplyStockRatio()
    {
        return [
            'no_stock' => Supply::noStock()->count(),
            'low_stock' => Supply::lowStock()->count(),
            'sufficient_stock' => Supply::sufficientStock()->count()
        ];
    }
}
