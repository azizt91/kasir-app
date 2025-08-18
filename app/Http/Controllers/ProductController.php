<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Milon\Barcode\DNS1D;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index(Request $request)
    // {
    //     $query = Product::with('category');

    //     // Search functionality
    //     if ($request->has('search') && $request->search) {
    //         $search = $request->search;
    //         $query->where(function ($q) use ($search) {
    //             $q->where('name', 'like', "%{$search}%")
    //               ->orWhere('barcode', 'like', "%{$search}%")
    //               ->orWhereHas('category', function ($cat) use ($search) {
    //                   $cat->where('name', 'like', "%{$search}%");
    //               });
    //         });
    //     }

    //     // Filter by category
    //     if ($request->has('category') && $request->category) {
    //         $query->where('category_id', $request->category);
    //     }

    //     // Filter by stock status
    //     if ($request->has('stock_status') && $request->stock_status) {
    //         if ($request->stock_status === 'low') {
    //             $query->lowStock();
    //         } elseif ($request->stock_status === 'out') {
    //             $query->where('stock', 0);
    //         }
    //     }

    //     $products = $query->latest()->paginate(10);
    //     $categories = Category::all();

    //     return view('products.index', [
    //         'products' => $products,
    //         'categories' => $categories,
    //         'filters' => $request->only(['search', 'category', 'stock_status'])
    //     ]);
    // }
    // Di dalam file: app/Http-Controllers/ProductController.php

    public function index(Request $request)
    {
        // [TAMBAHKAN INI] Ambil dan validasi nilai per_page dari URL
        $perPage = $request->query('per_page', 10);
        $allowedPerPages = [10, 20, 50, 100];
        if (!in_array((int)$perPage, $allowedPerPages)) {
            $perPage = 10; // Set ke default 10 jika nilainya tidak valid
        }

        $query = Product::with('category');

        // Search functionality (tidak berubah)
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('barcode', 'like', "%{$search}%")
                ->orWhereHas('category', function ($cat) use ($search) {
                    $cat->where('name', 'like', "%{$search}%");
                });
            });
        }

        // Filter by category (tidak berubah)
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Filter by stock status (tidak berubah)
        if ($request->has('stock_status') && $request->stock_status) {
            if ($request->stock_status === 'low') {
                $query->lowStock();
            } elseif ($request->stock_status === 'out') {
                $query->where('stock', 0);
            }
        }

        // [UBAH INI] Ganti angka 10 dengan variabel $perPage
        $products = $query->latest()->paginate($perPage);

        $categories = Category::all();

        return view('products.index', [
            'products' => $products,
            'categories' => $categories,
            // (Opsional) Anda bisa menambahkan per_page di sini jika perlu
            'filters' => $request->only(['search', 'category', 'stock_status', 'per_page'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view('products.create', [
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        $product = Product::create($validated);

        // Record initial stock movement if stock > 0
        if ($product->stock > 0) {
            StockMovement::create([
                'product_id' => $product->id,
                'type' => 'in',
                'quantity' => $product->stock,
                'notes' => 'Stok awal produk'
            ]);
        }

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load(['category', 'stockMovements' => function ($query) {
            $query->latest()->take(10);
        }]);

        return view('products.show', [
            'product' => $product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();

        return view('products.edit', [
            'product' => $product,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $oldStock = $product->stock;
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            // Store new image
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image'] = $imagePath;
        }

        // Handle image removal
        if ($request->input('remove_image') == '1') {
            // Delete old image if exists
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = null;
        }

        $product->update($data);

        // Record stock movement if stock changed
        if ($oldStock !== $product->stock) {
            $difference = $product->stock - $oldStock;
            StockMovement::create([
                'product_id' => $product->id,
                'type' => $difference > 0 ? 'in' : 'out',
                'quantity' => abs($difference),
                'notes' => 'Penyesuaian stok manual'
            ]);
        }

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Check if product is used in any transactions
        if ($product->transactionItems()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak dapat dihapus karena sudah digunakan dalam transaksi penjualan. Untuk menghentikan penjualan produk ini, ubah stok menjadi 0.'
            ], 422);
        }

        // Delete related stock movements first
        $product->stockMovements()->delete();

        // Delete product image if exists
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil dihapus'
        ]);
    }

    public function printBarcodes(Request $request)
    {
        $productIds = $request->input('selected_ids');

        // Cek apakah ada produk yang dipilih, jika tidak, ambil semua produk
        if ($productIds && is_array($productIds)) {
            $productsToPrint = Product::whereIn('id', $productIds)->get();
        } else {
            $productsToPrint = Product::all();
        }

        // Jika tidak ada produk sama sekali, kembali
        if ($productsToPrint->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada produk untuk dicetak.');
        }

        // Kirim data produk ke view khusus untuk cetak barcode
        return view('products.barcodes', ['products' => $productsToPrint]);
    }


}
