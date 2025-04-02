<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dash()
    {
        $totalOrders = Order::count();
        $totalAmount = Order::sum('total');

        $pendingOrders = Order::where('status', 'pending')->count();
        $pendingAmount = Order::where('status', 'pending')->sum('total');

        $deliveredOrders = Order::where('status', 'Completed')->count();
        $deliveredAmount = Order::where('status', 'Completed')->sum('total');

        $canceledOrders = Order::where('status', 'rejected','cancelled')->count();
        $canceledAmount = Order::where('status', 'rejected','cancelled')->sum('total');

        $totalRevenue = $deliveredAmount;
        $previousRevenue = 50000; 
        $growthPercentage = $previousRevenue > 0
            ? (($totalRevenue - $previousRevenue) / $previousRevenue) * 100
            : 0;

        return view('admin.index', compact(
            'totalOrders',
            'totalAmount',
            'pendingOrders',
            'pendingAmount',
            'deliveredOrders',
            'deliveredAmount',
            'canceledOrders',
            'canceledAmount',
            'totalRevenue',
            'growthPercentage'
        ));
    }
}
