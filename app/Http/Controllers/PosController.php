<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\StockMovement;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PosController extends Controller
{
    /**
     * Display the POS interface.
     */
    public function index()
    {
        $categories = Category::all();
        return view('pos.index', compact('categories'));
    }

    /**
     * Search products for POS.
     */
    // public function searchProducts(Request $request)
    // {
    //     $query = $request->get('q');
    //     $category = $request->get('category');
    //     $page = $request->get('page', 1);
    //     $perPage = $request->get('per_page', 10);

    //     $productsQuery = Product::with('category')
    //         ->where('stock', '>', 0);

    //     // Filter by category if specified
    //     if ($category && $category !== 'all') {
    //         $productsQuery->whereHas('category', function($q) use ($category) {
    //             $q->where('id', $category);
    //         });
    //     }

    //     // Filter by search query if specified
    //     if (!empty($query) && strlen($query) >= 2) {
    //         $productsQuery->where(function ($q) use ($query) {
    //             $q->where('name', 'like', "%{$query}%")
    //               ->orWhere('barcode', 'like', "%{$query}%");
    //         });
    //     }

    //     // Paginate results
    //     $products = $productsQuery
    //         ->skip(($page - 1) * $perPage)
    //         ->take($perPage)
    //         ->get(['id', 'name', 'barcode', 'selling_price', 'stock', 'category_id', 'image']);

    //     $total = $productsQuery->count();

    //     return response()->json([
    //         'products' => $products,
    //         'total' => $total,
    //         'current_page' => $page,
    //         'per_page' => $perPage,
    //         'last_page' => ceil($total / $perPage)
    //     ]);
    // }

    public function searchProducts(Request $request)
    {
        // Mengambil parameter dari request
        $query = $request->get('q');
        $category = $request->get('category');
        $perPage = $request->get('per_page', 10);

        // Membangun query dasar
        $productsQuery = Product::with('category')
            ->where('stock', '>', 0);

        // Filter berdasarkan kategori jika ada
        if ($category && $category !== 'all') {
            $productsQuery->where('category_id', $category);
        }

        // Filter berdasarkan query pencarian jika ada
        if (!empty($query)) {
            $productsQuery->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                ->orWhere('barcode', 'like', "%{$query}%");
            });
        }

        // [BAGIAN TERPENTING]
        // Gunakan ->paginate() untuk menghasilkan objek paginator yang lengkap.
        // latest() digunakan untuk mengurutkan dari yang terbaru, ini opsional.
        $products = $productsQuery->latest()->paginate($perPage);

        // [SOLUSI]
        // Cukup kembalikan objek $products. Laravel akan secara otomatis mengubahnya
        // menjadi response JSON yang terstruktur dengan benar.
        return response()->json($products);
    }

    public function getCategories()
    {
        $categories = \App\Models\Category::select('id', 'name')->get();
        return response()->json($categories);
    }

    /**
     * Show product search results for POS.
     */
    public function show(Request $request)
    {
        $query = $request->get('q', '');

        if (empty($query)) {
            return response()->json([]);
        }

        $products = Product::with('category')
            ->where(function ($q) use ($query) {
                $q->where('barcode', $query)
                  ->orWhere('name', 'like', "%{$query}%");
            })
            ->where('stock', '>', 0)
            ->take(10)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'barcode' => $product->barcode,
                    'name' => $product->name,
                    'category' => $product->category->name,
                    'selling_price' => (float) $product->selling_price,
                    'stock' => $product->stock,
                    'is_low_stock' => $product->is_low_stock,
                ];
            });

        return response()->json($products);
    }

    /**
     * Process transaction.
     */
    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|in:cash,card,ewallet,transfer',
            'amount_paid' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'customer_name' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $subtotal = 0;
            $items = [];

            // Process each item and calculate subtotal
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);

                // Check stock availability
                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Stok {$product->name} tidak mencukupi. Stok tersedia: {$product->stock}");
                }

                $itemSubtotal = (float) $product->selling_price * $item['quantity'];
                $subtotal += $itemSubtotal;

                $items[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'price' => $product->selling_price,
                    'subtotal' => $itemSubtotal,
                ];
            }

            $discount = $request->discount ?? 0;
            $tax = 0; // No tax for now
            $totalAmount = $subtotal - $discount + $tax;
            $amountPaid = $request->amount_paid;
            $changeAmount = $amountPaid - $totalAmount;

            if ($changeAmount < 0) {
                throw new \Exception('Jumlah pembayaran kurang dari total belanja.');
            }

            // Create transaction
            $transaction = Transaction::create([
                'transaction_code' => Transaction::generateTransactionCode(),
                'user_id' => auth()->id(),
                'subtotal' => $subtotal,
                'discount' => $discount,
                'tax' => $tax,
                'total_amount' => $totalAmount,
                'payment_method' => $request->payment_method,
                'amount_paid' => $amountPaid,
                'change_amount' => $changeAmount,
                'status' => 'completed',
            ]);

            // Create transaction items and update stock
            foreach ($items as $item) {
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['product']->id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal'],
                ]);

                // Update product stock
                $item['product']->decrement('stock', $item['quantity']);

                // Record stock movement
                StockMovement::create([
                    'product_id' => $item['product']->id,
                    'type' => 'out',
                    'quantity' => $item['quantity'],
                    'reference_type' => 'App\Models\Transaction',
                    'reference_id' => $transaction->id,
                    'notes' => "Penjualan - {$transaction->transaction_code}",
                ]);
            }

            DB::commit();

            // Load transaction with items for receipt
            $transaction->load(['items.product', 'user']);

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil diproses.',
                'transaction' => $transaction,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $transaction->load(['items.product', 'user']);

        return response()->json($transaction);
    }
}
