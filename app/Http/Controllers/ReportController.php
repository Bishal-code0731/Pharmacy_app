<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Inventory;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        $startDate = now()->subMonth();
        $endDate = now();

        return view('reports.index', [
            'salesData' => $this->getSalesReport($startDate, $endDate),
            'inventoryData' => $this->getInventoryReport(),
            'startDate' => $startDate->format('Y-m-d'),
            'endDate' => $endDate->format('Y-m-d')
        ]);
    }

    protected function getSalesReport($startDate, $endDate)
    {
        return Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'completed')
            ->orderBy('created_at')
            ->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('Y-m-d');
            });
    }

    protected function getInventoryReport()
    {
        return Inventory::orderBy('quantity')
            ->get()
            ->groupBy(function($item) {
                if ($item->quantity < 10) return 'Low Stock';
                if ($item->quantity < 20) return 'Medium Stock';
                return 'High Stock';
            });
    }
}