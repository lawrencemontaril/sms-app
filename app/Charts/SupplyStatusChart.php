<?php

namespace App\Charts;

use App\Models\Supply;
use App\Models\SupplyRequest;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\DB;

class SupplyStatusChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build()
    {
        // Define the statuses you want to show in the chart
        $statuses = ['sufficient_stock', 'low_stock', 'no_stock'];

        // Fetch counts from DB
        $counts = [
            'sufficient_stock' => Supply::sufficientStock()->count(),
            'low_stock' => Supply::lowStock()->count(),
            'no_stock' => Supply::noStock()->count(),
        ];

        // Ensure all statuses exist (fill missing with 0)
        $finalCounts = array_map(fn ($status) => $counts[$status] ?? 0, $statuses);

        return $this->chart->pieChart()
            ->setTitle('Supply Request Status Chart')
            ->addData($finalCounts)
            ->setLabels(array_map(fn ($status) => ucfirst(str_replace('_', ' ', $status)), $statuses))
            ->setColors([
                '#22c55e', '#ef4444', '#6b7280'
            ])
            ->toVue();
    }
}
