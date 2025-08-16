<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        // Get basic statistics
        $stats = [
            'total_products' => Product::count(),
            'low_stock_products' => Product::lowStock()->count(),
            'total_transactions' => Transaction::whereDate('created_at', today())->count(),
            'daily_sales' => Transaction::whereDate('created_at', today())->sum('total_amount'),
        ];

        // Get recent transactions (last 10)
        $recent_transactions = Transaction::with(['user', 'items.product'])
            ->latest()
            ->take(10)
            ->get();

        // Get low stock products
        $low_stock_products = Product::with('category')
            ->lowStock()
            ->take(10)
            ->get();

        // Get top selling products (this week)
        $top_products = Product::withSum(['transactionItems as total_sold' => function ($query) {
            $query->whereHas('transaction', function ($q) {
                $q->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
            });
        }], 'quantity')
        ->whereHas('transactionItems.transaction', function ($q) {
            $q->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        })
        ->orderByDesc('total_sold')
        ->take(5)
        ->get();

        // Sales chart data (last 7 days)
        $sales_chart = [];
        $daily_sales = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $total = Transaction::whereDate('created_at', $date)->sum('total_amount');
            $sales_chart[] = [
                'date' => $date->format('Y-m-d'),
                'total' => $total,
            ];
            $daily_sales[] = $total;
        }

        // Category distribution for pie chart
        $category_distribution = Category::withCount('products')
            ->having('products_count', '>', 0)
            ->orderByDesc('products_count')
            ->get()
            ->map(function ($category) {
                return (object) [
                    'name' => $category->name,
                    'product_count' => $category->products_count
                ];
            });

        return view('dashboard', [
            'stats' => $stats,
            'recent_transactions' => $recent_transactions,
            'low_stock_products' => $low_stock_products,
            'top_products' => $top_products,
            'sales_chart' => $sales_chart,
            'daily_sales' => $daily_sales,
            'category_distribution' => $category_distribution,
            'user_role' => $user->role,
        ]);
    }
}