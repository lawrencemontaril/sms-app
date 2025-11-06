<?php

namespace App\Charts;

use App\Models\SupplyRequest;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\DB;

class SupplyRequestStatusChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build()
    {
        // Define the statuses you want to show in the chart
        $statuses = ['pending', 'approved', 'rejected'];

        // Fetch counts from DB
        $counts = SupplyRequest::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        // Ensure all statuses exist (fill missing with 0)
        $finalCounts = array_map(fn ($status) => $counts[$status] ?? 0, $statuses);

        return $this->chart->pieChart()
            ->setTitle('Supply Request Status Chart')
            ->addData($finalCounts)
            ->setLabels(array_map('ucfirst', $statuses))
            ->setColors([
                '#f59e0b', '#10b981', '#ef4444',
            ])
            ->toVue();
    }
}
