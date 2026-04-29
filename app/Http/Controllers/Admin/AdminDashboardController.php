<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_orders'    => Order::count(),
            'total_revenue'   => Order::where('status', '!=', 'cancelled')->sum('total_amount'),
            'total_products'  => Product::where('is_active', true)->count(),
            'total_users'     => User::where('is_admin', false)->count(),
            'pending_orders'  => Order::where('status', 'pending')->count(),
            'low_stock'       => Product::where('stock', '<', 5)->where('is_active', true)->count(),
        ];

        $recent_orders = Order::with('user')->latest()->limit(8)->get();

        $monthly_revenue = Order::selectRaw('MONTH(created_at) as month, SUM(total_amount) as total')
            ->whereYear('created_at', date('Y'))
            ->where('status', '!=', 'cancelled')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        return view('admin.dashboard', compact('stats', 'recent_orders', 'monthly_revenue'));
    }
}
