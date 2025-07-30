<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Inventory;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use App\Notifications\OrderProcessed; 

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // $user->notify(new OrderProcessed($order));
        return view('dashboard', [
             'unreadNotificationsCount' => $user->unreadNotifications()->count(),
            'todaysOrdersCount' => Order::whereDate('created_at', today())->count(),
            'lowStockItemsCount' => Inventory::where('quantity', '<', 10)->count(),
            'pendingOrdersCount' => Order::where('status', 'pending')->count(),
            'recentActivities' => Activity::latest()->take(5)->get()
        ]);
    }
}