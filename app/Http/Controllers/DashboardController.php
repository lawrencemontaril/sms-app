<?php

namespace App\Http\Controllers;

use App\Http\Resources\SupplyResource;
use App\Models\Supply;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke(AnalyticsService $analyticsService)
    {
        return Inertia::render('Dashboard', [
            'total_supplies' => Inertia::defer(fn () => $analyticsService->getTotalSupplies()),
            'total_supply_cost' => Inertia::defer(fn () => $analyticsService->getTotalSupplyCost()),
            'total_supply_requests' => Inertia::defer(fn () => $analyticsService->getTotalSupplyRequests()),
            'total_approved_supply_requests' => Inertia::defer(fn () => $analyticsService->getTotalApprovedSupplyRequests()),
            'total_rejected_supply_requests' => Inertia::defer(fn () => $analyticsService->getTotalRejectedSupplyRequests()),
            'approved_rejected_ratio' => Inertia::defer(fn () => $analyticsService->getSupplyRequestApprovedRejectedRatio()),
            'supply_stock_ratio' => Inertia::defer(fn () => $analyticsService->getSupplyStockRatio()),
            'low_stock_supplies' => Inertia::defer(fn () => SupplyResource::collection(Supply::lowStock()->get())),
        ]);
    }
}
