@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="sm:flex sm:items-center sm:justify-between pb-6 border-b-2 border-gray-200">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">📦 Manajemen Produk</h1>
                <p class="text-gray-600 mt-1">Kelola semua produk dan stok di toko Anda.</p>
            </div>
            <div class="mt-4 sm:mt-0 flex items-center space-x-3">

                {{-- Tombol Dropdown Cetak Barcode --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="w-full sm:w-auto flex items-center justify-center px-5 py-3 bg-white text-gray-700 border border-gray-300 font-medium rounded-lg hover:bg-gray-50 shadow-sm transition duration-150">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                        Cetak Barcode
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10" style="display: none;">
                        <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                            <button @click="printSelectedBarcodes()" id="print-selected-btn" class="w-full text-left flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed" role="menuitem" disabled>
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Cetak Terpilih (<span id="selected-count">0</span>)
                            </button>
                            <a href="{{ route('products.print_barcodes') }}" target="_blank" class="w-full text-left flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                Cetak Semua Produk
                            </a>
                        </div>
                    </div>
                </div>

                <a href="{{ route('products.create') }}" class="w-full sm:w-auto flex items-center justify-center px-5 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 shadow-md transition-transform transform hover:scale-105 duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Tambah Produk Baru
                </a>
            </div>
        </div>

        <!-- Search & Filter Card -->
        <div class="mt-8 bg-white rounded-xl shadow-md border border-gray-200 p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
                <div class="sm:col-span-2 lg:col-span-2">
                    <label for="search-input" class="block text-sm font-medium text-gray-700 mb-1">Cari Produk</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" id="search-input" placeholder="Cari nama atau barcode..." class="pl-10 w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ request('search') }}">
                    </div>
                </div>
                <div>
                    <label for="category-filter" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select id="category-filter" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" @selected(request('category') == $cat->id)>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="stock-filter" class="block text-sm font-medium text-gray-700 mb-1">Status Stok</label>
                    <select id="stock-filter" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Semua Status</option>
                        <option value="low" @selected(request('stock_status') == 'low')>Stok Rendah</option>
                        <option value="out" @selected(request('stock_status') == 'out')>Stok Habis</option>
                    </select>
                </div>
                <div>
                    <label for="per-page-filter" class="block text-sm font-medium text-gray-700 mb-1">Per Halaman</label>
                    <select id="per-page-filter" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="10" @selected(request('per_page', 10) == 10)>10</option>
                        <option value="20" @selected(request('per_page') == 20)>20</option>
                        <option value="50" @selected(request('per_page') == 50)>50</option>
                        <option value="100" @selected(request('per_page') == 100)>100</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Tabel Produk -->
        <div class="mt-8">
            @if($products->isEmpty())
                <div class="text-center py-20 bg-white rounded-lg shadow-md">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada produk</h3>
                    <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan produk pertama Anda.</p>
                    <div class="mt-6">
                        <a href="{{ route('products.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            Tambah Produk
                        </a>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="relative px-6 py-3">
                                    <input type="checkbox" id="select-all-checkbox" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Jual</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($products as $product)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="relative px-6 py-4">
                                        <input type="checkbox" class="product-checkbox h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" value="{{ $product->id }}">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-12 w-12">
                                                <img class="h-12 w-12 rounded-lg object-cover" src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/150' }}" alt="{{ $product->name }}">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $product->barcode }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">{{ $product->category->name ?? '-' }}</span></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold {{ $product->stock <= $product->minimum_stock ? ($product->stock == 0 ? 'text-red-600' : 'text-yellow-600') : 'text-gray-900' }}">{{ $product->stock }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($product->stock <= $product->minimum_stock)
                                            @if($product->stock == 0)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Habis</span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Rendah</span>
                                            @endif
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Normal</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <a href="{{ route('products.show', $product) }}" class="text-gray-500 hover:text-indigo-600" title="Detail"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg></a>
                                            <a href="{{ route('products.edit', $product) }}" class="text-gray-500 hover:text-green-600" title="Edit"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></a>
                                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline" id="delete-form-{{ $product->id }}">@csrf @method('DELETE')<button type="button" onclick="confirmDelete({{ $product->id }}, '{{ addslashes($product->name) }}')" class="text-gray-500 hover:text-red-600" title="Hapus"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button></form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $products->withQueryString()->links() }}
        </div>
    </div>
</div>

@push('scripts')
{{-- Pastikan Alpine.js sudah dimuat di layouts/app.blade.php Anda --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- LOGIKA FILTER ---
        const searchInput = document.getElementById('search-input');
        const categoryFilter = document.getElementById('category-filter');
        const stockFilter = document.getElementById('stock-filter');
        const perPageFilter = document.getElementById('per-page-filter'); // Elemen baru
        let searchTimeout;

        function applyFilters() {
            const url = new URL(window.location.href);
            url.searchParams.set('search', searchInput.value.trim());
            url.searchParams.set('category', categoryFilter.value);
            url.searchParams.set('stock_status', stockFilter.value);
            url.searchParams.set('per_page', perPageFilter.value); // Tambahkan parameter per_page
            url.searchParams.set('page', '1');
            window.location.href = url.toString();
        }

        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(applyFilters, 500);
        });
        categoryFilter.addEventListener('change', applyFilters);
        stockFilter.addEventListener('change', applyFilters);
        perPageFilter.addEventListener('change', applyFilters); // Tambahkan event listener

        // --- LOGIKA CETAK BARCODE (CHECKBOX) ---
        const selectAllCheckbox = document.getElementById('select-all-checkbox');
        const productCheckboxes = document.querySelectorAll('.product-checkbox');
        const printSelectedBtn = document.getElementById('print-selected-btn');
        const selectedCountSpan = document.getElementById('selected-count');

        if (selectAllCheckbox && productCheckboxes.length > 0) {
            function updateSelectionState() {
                const selected = document.querySelectorAll('.product-checkbox:checked');
                selectedCountSpan.textContent = selected.length;
                printSelectedBtn.disabled = selected.length === 0;

                if (selected.length > 0 && selected.length === productCheckboxes.length) {
                    selectAllCheckbox.checked = true;
                    selectAllCheckbox.indeterminate = false;
                } else if (selected.length > 0) {
                    selectAllCheckbox.checked = false;
                    selectAllCheckbox.indeterminate = true;
                } else {
                    selectAllCheckbox.checked = false;
                    selectAllCheckbox.indeterminate = false;
                }
            }

            selectAllCheckbox.addEventListener('change', function() {
                productCheckboxes.forEach(checkbox => {
                    checkbox.checked = selectAllCheckbox.checked;
                });
                updateSelectionState();
            });

            productCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateSelectionState);
            });

            updateSelectionState();
        }
    });

    // --- FUNGSI KONFIRMASI HAPUS ---
    function confirmDelete(productId, productName) {
        Swal.fire({
            title: `Hapus produk "${productName}"?`,
            text: "Anda tidak akan bisa mengembalikan data ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + productId).submit();
            }
        });
    }

    // --- FUNGSI CETAK BARCODE TERPILIH ---
    function printSelectedBarcodes() {
        const selectedIds = Array.from(document.querySelectorAll('.product-checkbox:checked')).map(cb => cb.value);

        if (selectedIds.length === 0) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Pilih setidaknya satu produk untuk dicetak barcodenya!',
            });
            return;
        }

        const url = new URL("{{ route('products.print_barcodes') }}");
        selectedIds.forEach(id => url.searchParams.append('selected_ids[]', id));

        window.open(url.toString(), '_blank');
    }
</script>
@endpush
@endsection
