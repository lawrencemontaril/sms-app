<?php

namespace App\Http\Controllers;

use App\Charts\SupplyRequestStatusChart;
use App\Charts\SupplyStatusChart;
use App\Http\Resources\SupplyResource;
use App\Models\Supply;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke(
        AnalyticsService $analyticsService,
        SupplyRequestStatusChart $supplyRequestStatusChart,
        SupplyStatusChart $supplyStatusChart
    ) {
        return Inertia::render('Dashboard', [
            'total_supplies' => Inertia::defer(fn () => $analyticsService->getTotalSupplies()),
            'total_supply_cost' => Inertia::defer(fn () => $analyticsService->getTotalSupplyCost()),
            'total_supply_requests' => Inertia::defer(fn () => $analyticsService->getTotalSupplyRequests()),
            'total_approved_supply_requests' => Inertia::defer(fn () => $analyticsService->getTotalApprovedSupplyRequests()),
            'total_rejected_supply_requests' => Inertia::defer(fn () => $analyticsService->getTotalRejectedSupplyRequests()),
            'supplyRequestStatusChart' => Inertia::defer(fn () => $supplyRequestStatusChart->build()),
            'supplyStatusChart' => Inertia::defer(fn () => $supplyStatusChart->build()),
            'low_stock_supplies' => Inertia::defer(fn () => SupplyResource::collection(Supply::lowStock()->get())),
        ]);
    }
}
