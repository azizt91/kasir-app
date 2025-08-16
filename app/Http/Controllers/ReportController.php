<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Routing\Controller as BaseController;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SalesReportExport;
use App\Exports\ProductReportExport;
use App\Exports\StockReportExport;

class ReportController extends BaseController
{
    private function checkAdminAccess()
    {
        if (!auth()->check()) {
            abort(401, 'Silakan login terlebih dahulu.');
        }
        
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Hanya admin yang dapat mengakses laporan.');
        }
    }

    public function index()
    {
        $this->checkAdminAccess();
        
        // Get summary statistics
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();
        $thisYear = Carbon::now()->startOfYear();

        $stats = [
            'today_sales' => Transaction::whereDate('created_at', $today)->sum('total_amount'),
            'today_transactions' => Transaction::whereDate('created_at', $today)->count(),
            'month_sales' => Transaction::where('created_at', '>=', $thisMonth)->sum('total_amount'),
            'month_transactions' => Transaction::where('created_at', '>=', $thisMonth)->count(),
            'year_sales' => Transaction::where('created_at', '>=', $thisYear)->sum('total_amount'),
            'year_transactions' => Transaction::where('created_at', '>=', $thisYear)->count(),
            'total_products' => Product::count(),
            'low_stock_products' => Product::whereRaw('stock <= minimum_stock')->count(),
            'total_categories' => Category::count(),
            'total_users' => User::count(),
        ];

        // Recent transactions
        $recentTransactions = Transaction::with('user')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Top selling products this month
        $topProducts = Product::select([
                'products.id',
                'products.name',
                'products.barcode',
                'products.category_id',
                'products.selling_price',
                'products.image'
            ])
            ->selectRaw('SUM(transaction_items.quantity) as total_sold')
            ->selectRaw('SUM(transaction_items.subtotal) as total_revenue')
            ->with('category')
            ->join('transaction_items', 'products.id', '=', 'transaction_items.product_id')
            ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->where('transactions.created_at', '>=', $thisMonth)
            ->groupBy([
                'products.id',
                'products.name',
                'products.barcode',
                'products.category_id',
                'products.selling_price',
                'products.image'
            ])
            ->orderBy('total_sold', 'desc')
            ->take(10)
            ->get();

        // Low stock products
        $lowStockProducts = Product::with('category')
            ->whereRaw('stock <= minimum_stock')
            ->orderBy('stock', 'asc')
            ->take(10)
            ->get();

        return view('reports.index', compact('stats', 'recentTransactions', 'topProducts', 'lowStockProducts'));
    }

    public function sales(Request $request)
    {
        $this->checkAdminAccess();
        
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));
        $format = $request->get('format', 'view');

        $transactions = Transaction::with(['user', 'items.product'])
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->orderBy('created_at', 'desc')
            ->get();

        $summary = [
            'total_transactions' => $transactions->count(),
            'total_amount' => $transactions->sum('total_amount'),
            'total_discount' => $transactions->sum('discount'),
            'total_tax' => $transactions->sum('tax'),
            'average_transaction' => $transactions->count() > 0 ? $transactions->sum('total_amount') / $transactions->count() : 0,
        ];

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('reports.sales-pdf', compact('transactions', 'summary', 'startDate', 'endDate'));
            return $pdf->download('laporan-penjualan-' . $startDate . '-to-' . $endDate . '.pdf');
        }

        if ($format === 'excel') {
            return Excel::download(new SalesReportExport($transactions, $summary, $startDate, $endDate), 
                'laporan-penjualan-' . $startDate . '-to-' . $endDate . '.xlsx');
        }

        return view('reports.sales', compact('transactions', 'summary', 'startDate', 'endDate'));
    }

    public function products(Request $request)
    {
        $this->checkAdminAccess();
        
        $category = $request->get('category');
        $format = $request->get('format', 'view');

        $query = Product::with('category');
        
        if ($category) {
            $query->where('category_id', $category);
        }

        $products = $query->orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        $summary = [
            'total_products' => $products->count(),
            'total_stock_value' => $products->sum(function($product) {
                return $product->stock * $product->purchase_price;
            }),
            'total_selling_value' => $products->sum(function($product) {
                return $product->stock * $product->selling_price;
            }),
            'low_stock_count' => $products->filter(function($product) {
                return $product->stock <= $product->minimum_stock;
            })->count(),
        ];

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('reports.products-pdf', compact('products', 'summary', 'category'));
            return $pdf->download('laporan-produk-' . date('Y-m-d') . '.pdf');
        }

        if ($format === 'excel') {
            return Excel::download(new ProductReportExport($products, $summary), 
                'laporan-produk-' . date('Y-m-d') . '.xlsx');
        }

        return view('reports.products', compact('products', 'categories', 'summary', 'category'));
    }

    public function stock(Request $request)
    {
        $this->checkAdminAccess();
        
        $status = $request->get('status', 'all'); // all, low, out
        $format = $request->get('format', 'view');

        $query = Product::with('category');

        switch ($status) {
            case 'low':
                $query->whereRaw('stock <= minimum_stock AND stock > 0');
                break;
            case 'out':
                $query->where('stock', 0);
                break;
            default:
                // all products
                break;
        }

        $products = $query->orderBy('stock', 'asc')->get();

        $summary = [
            'total_products' => Product::count(),
            'low_stock_products' => Product::whereRaw('stock <= minimum_stock AND stock > 0')->count(),
            'out_of_stock_products' => Product::where('stock', 0)->count(),
            'normal_stock_products' => Product::whereRaw('stock > minimum_stock')->count(),
        ];

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('reports.stock-pdf', compact('products', 'summary', 'status'));
            return $pdf->download('laporan-stok-' . date('Y-m-d') . '.pdf');
        }

        if ($format === 'excel') {
            return Excel::download(new StockReportExport($products, $summary), 
                'laporan-stok-' . date('Y-m-d') . '.xlsx');
        }

        return view('reports.stock', compact('products', 'summary', 'status'));
    }
}
