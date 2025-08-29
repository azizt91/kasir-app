@extends('layouts.app')

@section('scripts')
<script>
    const STORE_SETTINGS = @json($storeSettings ?? [
        'store_name' => 'Toko Anda',
        'store_address' => 'Alamat Toko Anda',
        'store_phone' => 'No. Telepon Anda'
    ]);
    const AUTH_USER = @json(auth()->user() ? ['name' => auth()->user()->name] : ['name' => 'Kasir']);
</script>
@endsection

@section('content')
<div class="p-4 sm:p-6 lg:p-8 min-h-screen">
    <!-- Page Header -->
    <div class="mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Point of Sale</h1>
                <p class="text-gray-600 mt-1">Scan, add products, and process transactions</p>
            </div>
            <div class="mt-4 sm:mt-0 flex items-center space-x-3">
                <div class="flex items-center px-3 py-2 bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></div>
                    <span class="text-sm font-medium text-gray-700">Online</span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        {{-- Products Section (Left Side) --}}
        <div class="lg:col-span-3 space-y-6">
            {{-- Search Area --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1 relative">
                        <input type="text" id="product-search" 
                               placeholder="Search products by name or barcode..." 
                               class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200" 
                               autocomplete="off">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <button onclick="openScannerModal()" 
                            class="px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl hover:from-indigo-600 hover:to-purple-700 flex items-center justify-center gap-2 transition-all duration-200 shadow-sm hover:shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="hidden sm:inline">Scan</span>
                    </button>
                </div>
                <div id="search-results" class="mt-4 space-y-2 max-h-60 overflow-y-auto scrollbar-thin"></div>
            </div>

            {{-- Category Tabs --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="border-b border-gray-200">
                    <nav id="category-tabs-container" class="-mb-px flex space-x-1 overflow-x-auto scrollbar-thin px-6 py-4"></nav>
                </div>
            </div>

            {{-- Products Grid --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Products</h3>
                        <p class="text-sm text-gray-500">Click on a product to add it to cart</p>
                    </div>
                </div>
                
                <div id="products-grid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 min-h-[400px]">
                    {{-- Products will be loaded here by JavaScript --}}
                </div>

                {{-- Pagination --}}
                <div class="flex flex-col sm:flex-row justify-between items-center mt-8 pt-6 border-t border-gray-200 gap-4">
                    <div class="flex items-center space-x-4">
                        <span id="pagination-info" class="text-sm text-gray-500"></span>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-500">per page</span>
                            <select id="per-page-select" 
                                    onchange="changePerPage(this.value)" 
                                    class="border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="10" selected>10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>
                    <div id="pagination-buttons" class="flex space-x-1"></div>
                </div>
            </div>
        </div>

        {{-- Cart Section (Right Side) --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-semibold text-gray-900">Shopping Cart</h3>
                    <button onclick="clearCart()" 
                            class="bg-red-50 hover:bg-red-100 text-red-600 px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200 border border-red-200">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Clear
                    </button>
                </div>
                
                <div id="cart-items-container" class="space-y-3 mb-6 max-h-80 overflow-y-auto scrollbar-thin">
                    {{-- Cart items will be populated here --}}
                </div>
                
                <div class="border-t border-gray-200 pt-6 space-y-3">
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>Subtotal</span>
                        <span id="subtotal" class="font-medium">Rp 0</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold text-gray-900">
                        <span>Total</span>
                        <span id="total">Rp 0</span>
                    </div>
                </div>
                
                <button id="checkout-button" 
                        onclick="openPaymentModal()" 
                        class="w-full mt-6 bg-gradient-to-r from-indigo-500 to-purple-600 text-white py-4 rounded-xl hover:from-indigo-600 hover:to-purple-700 font-semibold flex items-center justify-center gap-2 disabled:from-gray-400 disabled:to-gray-400 disabled:cursor-not-allowed transition-all duration-200 shadow-sm hover:shadow-md" 
                        disabled>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 1.5M7 13l1.5 1.5M17 21a2 2 0 100-4 2 2 0 000 4zM9 21a2 2 0 100-4 2 2 0 000 4z"></path>
                    </svg>
                    Checkout
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ================================= MODALS ================================= --}}

{{-- Modal untuk Barcode Scanner --}}
<div id="scanner-modal" class="fixed inset-0 bg-black bg-opacity-75 hidden flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md mx-auto overflow-hidden">
        <div class="p-4 border-b">
            <h3 class="text-lg font-semibold text-center">Arahkan Kamera ke Barcode</h3>
        </div>
        <div class="p-4 bg-gray-900">
            <video id="video-scanner" class="w-full h-64 rounded-lg"></video>
        </div>
        <div class="p-4 bg-gray-50 border-t">
            <button onclick="closeScannerModal()" class="w-full py-3 text-center font-bold text-white bg-red-500 hover:bg-red-600 rounded-lg transition">
                Tutup
            </button>
        </div>
    </div>
</div>

{{-- Modal Pembayaran --}}
<div id="payment-modal" class="fixed inset-0 bg-black bg-opacity-75 hidden flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm mx-auto overflow-hidden">

        <div class="grid grid-cols-2">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-4 text-white">
                <p class="text-sm font-medium opacity-80">Total Belanja</p>
                <p class="text-3xl font-bold tracking-tight" id="modal-total">Rp 0</p>
            </div>
            <div class="bg-gradient-to-br from-yellow-500 to-orange-500 p-4 text-white">
                <p class="text-sm font-medium opacity-80">Kembalian</p>
                <p class="text-3xl font-bold tracking-tight" id="modal-change">Rp 0</p>
            </div>
        </div>

        <div class="p-6 space-y-5">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="customer-name" class="block text-xs font-medium text-gray-500 mb-1">Nama Customer</label>
                    <input type="text" id="customer-name" placeholder="Umum"
                           class="w-full px-4 py-2 bg-gray-100 border-transparent rounded-lg focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                </div>
                 <div>
                    <label for="payment-method" class="block text-xs font-medium text-gray-500 mb-1">Metode Pembayaran</label>
                    <select id="payment-method"
                            class="w-full px-4 py-2 bg-gray-100 border-transparent rounded-lg focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                        <option value="">Pilih metode...</option>
                        <option value="cash">💵 Tunai</option>
                        <option value="card">💳 Kartu</option>
                        <option value="ewallet">📱 E-Wallet</option>
                        <option value="transfer">🏦 Transfer</option>
                    </select>
                </div>
            </div>

            <div>
                <label for="amount-paid" class="block text-xs font-medium text-gray-500 mb-1">Nominal Bayar</label>
                <div class="relative">
                     <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 font-medium">Rp</span>
                     <input type="number" id="amount-paid" placeholder="0"
                           class="w-full pl-9 pr-4 py-2 bg-gray-100 border-transparent rounded-lg focus:ring-2 focus:ring-blue-500 focus:bg-white transition text-lg font-semibold"
                           oninput="updateModalPayment()">
                </div>
            </div>

            <div class="grid grid-cols-3 sm:grid-cols-6 gap-2">
                <button type="button" onclick="setQuickAmount(50000)" class="px-2 py-2 text-sm bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 hover:scale-105 transition transform">50rb</button>
                <button type="button" onclick="setQuickAmount(100000)" class="px-2 py-2 text-sm bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 hover:scale-105 transition transform">100rb</button>
                <button type="button" onclick="setQuickAmount(150000)" class="px-2 py-2 text-sm bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 hover:scale-105 transition transform">150rb</button>
                <button type="button" onclick="setQuickAmount(200000)" class="px-2 py-2 text-sm bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 hover:scale-105 transition transform">200rb</button>
                <button type="button" onclick="setQuickAmount(500000)" class="px-2 py-2 text-sm bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 hover:scale-105 transition transform">500rb</button>
                <button type="button" onclick="setQuickAmount(1000000)" class="px-2 py-2 text-sm bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 hover:scale-105 transition transform">1jt</button>
            </div>
        </div>

        <div class="grid grid-cols-2">
            <button onclick="closePaymentModal()"
                    class="py-4 text-center font-bold text-white bg-gradient-to-br from-pink-500 to-red-500 hover:from-pink-600 hover:to-red-600 transition">
                Batal
            </button>
            <button onclick="processTransaction()"
                    class="py-4 text-center font-bold text-white bg-gradient-to-br from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700 transition">
                Bayar
            </button>
        </div>
    </div>
</div>

{{-- Modal Sukses --}}
<div id="success-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
        <div class="text-center">
            <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4"><svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Pembayaran Berhasil!</h3>
            <p class="text-gray-600 mb-6">Transaksi telah berhasil diproses</p>
            <div class="bg-gray-50 rounded-lg p-4 mb-6 text-left">
                <div class="grid grid-cols-2 gap-2 text-sm">
                    <div class="text-gray-600">No. Transaksi</div><div class="font-medium" id="transaction-id"></div>
                    <div class="text-gray-600">Total Bayar</div><div class="font-medium" id="success-total"></div>
                    <div class="text-gray-600">Kembalian</div><div class="font-medium text-green-600" id="success-change"></div>
                </div>
            </div>
            <div class="space-y-3">
                <div class="text-sm text-gray-600 mb-4">Cetak Struk?</div>
                <div class="flex space-x-3">
                    <button onclick="printReceipt()" class="flex-1 bg-green-500 text-white py-3 rounded-md hover:bg-green-600 font-medium">📄 Cetak Struk</button>
                    <button onclick="closeSuccessModal()" class="flex-1 bg-gray-500 text-white py-3 rounded-md hover:bg-gray-600 font-medium">✕ Lewati</button>
                </div>
                <div class="text-xs text-gray-500">Modal akan tertutup dalam <span id="countdown-timer" class="font-medium text-blue-600">10</span> detik</div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        /* Sembunyikan semua elemen di halaman secara default saat mencetak */
        body * {
            visibility: hidden;
        }

        /* Tampilkan HANYA area cetak dan semua isinya */
        #print-area, #print-area * {
            visibility: visible;
        }

        /* Posisikan area cetak di sudut kiri atas halaman cetak agar rapi */
        #print-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            display: block; /* <-- [TAMBAHKAN BARIS INI] Paksa elemen untuk tampil kembali */
        }
    }
</style>

<div id="print-area" class="hidden"></div>

{{-- ================================= SCRIPT ================================= --}}
<script>
    // === STATE MANAGEMENT ===
    let cart = [];
    let searchTimeout = null;
    let currentPage = 1;
    let currentCategory = 'all';
    let perPage = 10;
    let countdownInterval = null;
    window.currentTransaction = null;

    // === UTILITY FUNCTIONS ===
    const formatRupiah = (amount) => `Rp ${new Intl.NumberFormat('id-ID').format(amount)}`;

    // === INITIALIZATION ===
    document.addEventListener('DOMContentLoaded', function() {
        initPos();
    });

    function initPos() {
        console.log('Initializing POS system...');
        loadCategories();
        loadProducts();
        setupSearch();
        updateCartDisplay();
        document.getElementById('product-search')?.focus();
    }

    // === API & DATA FETCHING ===
    async function fetchData(url) {
        try {
            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            return await response.json();
        } catch (error) {
            console.error(`Error fetching from ${url}:`, error);
            return null;
        }
    }

    async function loadCategories() {
        const categories = await fetchData('/pos/categories');
        if (categories) renderCategoryTabs(categories);
    }

    // [GANTI SELURUH FUNGSI INI]
    async function loadProducts() {
        const searchInput = document.getElementById('product-search');
        const query = searchInput.value.trim();

        // [FIX] URL sekarang menggunakan variabel global `currentPage`
        const url = `/pos/products/search?q=${encodeURIComponent(query)}&page=${currentPage}&category=${currentCategory}&per_page=${perPage}`;

        const data = await fetchData(url);

        if (data) {
            // Logika untuk barcode scanner otomatis (sudah benar, tidak perlu diubah)
            const products = data.data || [];
            if (products.length === 1 && query.length > 5 && query === products[0].barcode) {
                const product = products[0];
                addToCart(product.id, product.name, product.selling_price, product.stock, product.image);
                searchInput.value = '';
                // Saat scan berhasil, panggil loadProducts dengan query kosong untuk kembali ke daftar semua produk
                currentPage = 1; // Reset ke halaman 1 setelah scan berhasil
                await loadProducts();
            } else {
                // Tampilkan hasil pencarian/halaman seperti biasa
                displayProductsGrid(products);
                updatePagination(data);
            }
        } else {
            document.getElementById('products-grid').innerHTML = '<p class="text-red-500 text-center col-span-full">Error memuat produk.</p>';
        }
    }

    // === RENDERING & DISPLAY LOGIC ===
    function renderCategoryTabs(categories) {
        const container = document.getElementById('category-tabs-container');
        if (!container) return;
        let tabsHTML = `<button onclick="filterByCategory('all', this)" class="category-tab px-6 py-4 text-sm font-medium text-white bg-teal-600 border-b-2 border-teal-600 whitespace-nowrap active">Semua</button>`;
        categories.forEach(category => {
            tabsHTML += `<button onclick="filterByCategory('${category.id}', this)" class="category-tab px-6 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent hover:border-gray-300 whitespace-nowrap">${category.name}</button>`;
        });
        container.innerHTML = tabsHTML;
    }

    function displayProductsGrid(products) {
        const grid = document.getElementById('products-grid');
        if (!products || products.length === 0) {
            grid.innerHTML = '<div class="col-span-full text-center text-gray-500 py-8">Tidak ada produk ditemukan</div>';
            return;
        }
        grid.innerHTML = products.map(p => `
            <div class="bg-white border rounded-lg p-3 hover:shadow-md transition-shadow cursor-pointer" onclick="addToCart(${p.id}, '${p.name.replace(/'/g, "\\'")}', ${p.selling_price}, ${p.stock}, '${p.image || ''}')">
                <div class="aspect-square bg-gray-100 rounded-lg mb-2 flex items-center justify-center overflow-hidden">
                    ${p.image ? `<img src="/storage/${p.image}" alt="${p.name}" class="w-full h-full object-cover">` : `<span class="text-2xl">📦</span>`}
                </div>
                <div class="text-sm font-medium text-gray-900 mb-1 line-clamp-2">${p.name}</div>
                <div class="text-xs text-gray-500 mb-2">Stok: ${p.stock}</div>
                <div class="text-sm font-bold text-teal-600">${formatRupiah(p.selling_price)}</div>
            </div>
        `).join('');
    }

    function updatePagination(data) {
        const infoEl = document.getElementById('pagination-info');
        const buttonsEl = document.getElementById('pagination-buttons');
        if (!infoEl || !buttonsEl || !data.total) {
            if(infoEl) infoEl.textContent = '';
            if(buttonsEl) buttonsEl.innerHTML = '';
            return;
        }
        infoEl.textContent = `Menampilkan ${data.from || 0} sampai ${data.to || 0} dari ${data.total} hasil`;
        let buttonsHTML = '';
        data.links.forEach(link => {
            if (link.url) {
                buttonsHTML += `<button onclick="changePage('${link.url}')" class="px-3 py-2 text-sm ${link.active ? 'bg-teal-600 text-white rounded' : 'text-gray-500 hover:text-gray-700'}">${link.label.replace('&laquo;', '‹').replace('&raquo;', '›')}</button>`;
            } else {
                buttonsHTML += `<span class="px-3 py-2 text-sm text-gray-400">${link.label.replace('&laquo;', '‹').replace('&raquo;', '›')}</span>`;
            }
        });
        buttonsEl.innerHTML = buttonsHTML;
    }

    // === SEARCH LOGIC ===
    function setupSearch() {
        const searchInput = document.getElementById('product-search');
        searchInput.addEventListener('input', () => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                currentPage = 1;
                loadProducts();
            }, 300);
        });
        searchInput.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                clearTimeout(searchTimeout);
                currentPage = 1;
                loadProducts();
            }
        });
    }

    // function focusSearchInput() {
    //     document.getElementById('product-search').focus();
    // }

    // Variabel global untuk instance scanner
    let codeReader = null;

    // Fungsi untuk membuka modal dan memulai scanner
    function openScannerModal() {
        // Inisialisasi library scanner jika belum ada
        if (!codeReader) {
            codeReader = new ZXing.BrowserMultiFormatReader();
        }

        document.getElementById('scanner-modal').classList.remove('hidden');

        // Minta izin kamera dan mulai memindai
        codeReader.listVideoInputDevices()
            .then((videoInputDevices) => {
                // Preferensi kamera belakang (environment) untuk mobile
                const firstDeviceId = videoInputDevices[0].deviceId;
                let selectedDeviceId = firstDeviceId;
                const rearCamera = videoInputDevices.find(device => device.label.toLowerCase().includes('back') || device.label.toLowerCase().includes('belakang'));
                if (rearCamera) {
                    selectedDeviceId = rearCamera.deviceId;
                }

                console.log(`Menggunakan kamera: ${selectedDeviceId}`);

                codeReader.decodeFromVideoDevice(selectedDeviceId, 'video-scanner', (result, err) => {
                    if (result) {
                        console.log('Barcode ditemukan:', result.text);

                        // Masukkan hasil scan ke input pencarian
                        const searchInput = document.getElementById('product-search');
                        searchInput.value = result.text;

                        // Tutup scanner dan jalankan pencarian
                        closeScannerModal();
                        loadProducts(); // Panggil fungsi pencarian produk
                    }
                    if (err && !(err instanceof ZXing.NotFoundException)) {
                        console.error('Error saat scanning:', err);
                    }
                });
            })
            .catch((err) => {
                console.error('Error akses kamera:', err);
                alert('Gagal mengakses kamera. Pastikan Anda memberikan izin dan menggunakan koneksi HTTPS.');
                closeScannerModal();
            });
    }

    // Fungsi untuk menutup modal dan menghentikan scanner
    function closeScannerModal() {
        if (codeReader) {
            codeReader.reset(); // Hentikan pemindaian dan lepaskan kamera
        }
        document.getElementById('scanner-modal').classList.add('hidden');
    }

    // === CART LOGIC ===
    function addToCart(id, name, price, stock, image) {
        const existingItem = cart.find(item => item.id === id);
        if (existingItem) {
            if (existingItem.quantity < stock) {
                existingItem.quantity++;
            } else {
                alert('Stok tidak mencukupi!');
            }
        } else {
            if (stock > 0) {
                cart.push({ id, name, price, stock, image, quantity: 1 });
            } else {
                alert('Stok produk habis!');
            }
        }
        updateCartDisplay();
        document.getElementById('product-search').value = '';
        document.getElementById('product-search').focus();
    }

    function updateCartDisplay() {
        const container = document.getElementById('cart-items-container');
        const checkoutButton = document.getElementById('checkout-button');
        if (cart.length === 0) {
            container.innerHTML = `<div class="text-center text-gray-500 py-8"><svg class="w-12 h-12 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 1.5M7 13l1.5 1.5M17 21a2 2 0 100-4 2 2 0 000 4zM9 21a2 2 0 100-4 2 2 0 000 4z"></path></svg>Keranjang kosong</div>`;
            checkoutButton.disabled = true;
        } else {
            container.innerHTML = cart.map(item => `
                <div class="flex items-center p-3 bg-gray-50 rounded-lg mb-3">
                    <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center mr-3 overflow-hidden flex-shrink-0">
                        ${item.image ? `<img src="/storage/${item.image}" alt="${item.name}" class="w-full h-full object-cover">` : `<span class="text-lg">📦</span>`}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-medium text-gray-900 truncate">${item.name}</div>
                        <div class="text-xs text-gray-500 mb-2">${formatRupiah(item.price)}</div>
                        <div class="flex items-center justify-between mt-2">
                             <div class="flex items-center space-x-1">
                                <button onclick="decreaseQuantity(${item.id})" class="w-6 h-6 bg-gray-200 rounded text-xs hover:bg-gray-300">-</button>
                                <span class="w-8 text-center text-sm">${item.quantity}</span>
                                <button onclick="increaseQuantity(${item.id})" class="w-6 h-6 bg-teal-600 text-white rounded text-xs hover:bg-teal-700">+</button>
                            </div>
                            <button onclick="removeFromCart(${item.id})" class="w-6 h-6 bg-red-500 text-white rounded text-xs hover:bg-red-600">×</button>
                        </div>
                    </div>
                </div>
            `).join('');
            checkoutButton.disabled = false;
        }
        updateCartTotals();
    }

    function increaseQuantity(id) {
        const item = cart.find(item => item.id === id);
        if (item && item.quantity < item.stock) {
            item.quantity++;
            updateCartDisplay();
        } else if (item) {
            alert('Stok tidak mencukupi!');
        }
    }

    function decreaseQuantity(id) {
        const item = cart.find(item => item.id === id);
        if (item && item.quantity > 1) {
            item.quantity--;
            updateCartDisplay();
        } else if (item) {
            removeFromCart(id);
        }
    }

    function removeFromCart(id) {
        cart = cart.filter(item => item.id !== id);
        updateCartDisplay();
    }

    function updateCartTotals() {
        const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        document.getElementById('subtotal').textContent = formatRupiah(total);
        document.getElementById('total').textContent = formatRupiah(total);
    }

    function clearCart() {
        if (confirm('Anda yakin ingin mereset keranjang?')) {
            cart = [];
            updateCartDisplay();
        }
    }

    // === EVENT HANDLERS & FILTERS ===
    async function changePage(url) {
        if (!url) {
            return; // Hentikan jika URL tidak valid
        }

        // Ambil nomor halaman dari URL yang diklik
        const pageNumber = new URL(url).searchParams.get('page');

        if (!pageNumber) {
            return; // Hentikan jika tidak ada nomor halaman
        }

        // Update variabel halaman saat ini
        currentPage = pageNumber;

        // Panggil fungsi untuk memuat produk dari halaman yang baru
        await loadProducts();
    }

    function filterByCategory(category, element) {
        document.querySelectorAll('.category-tab').forEach(tab => {
            tab.classList.remove('active', 'text-white', 'bg-teal-600', 'border-teal-600');
            tab.classList.add('text-gray-500', 'border-transparent');
        });
        element.classList.add('active', 'text-white', 'bg-teal-600', 'border-teal-600');
        element.classList.remove('text-gray-500', 'border-transparent');
        currentCategory = category;
        currentPage = 1;
        loadProducts();
    }

    function changePerPage(newPerPage) {
        perPage = parseInt(newPerPage);
        currentPage = 1;
        loadProducts();
    }

    // === MODAL & TRANSACTION LOGIC ===
    function openPaymentModal() {
        if (cart.length === 0) return;
        const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        document.getElementById('modal-total').textContent = formatRupiah(total);
        document.getElementById('amount-paid').value = total;
        updateModalPayment();
        document.getElementById('payment-modal').classList.remove('hidden');
        document.getElementById('amount-paid').focus();
    }

    function closePaymentModal() {
        document.getElementById('payment-modal').classList.add('hidden');
    }

    function setQuickAmount(amount) {
        document.getElementById('amount-paid').value = amount;
        updateModalPayment();
    }

    function updateModalPayment() {
        const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        const amount = parseFloat(document.getElementById('amount-paid').value) || 0;
        const change = Math.max(0, amount - total);
        document.getElementById('modal-change').textContent = formatRupiah(change);
    }

    async function processTransaction() {
        const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        const amountPaid = parseFloat(document.getElementById('amount-paid').value) || 0;
        const paymentMethod = document.getElementById('payment-method').value;
        if (cart.length === 0) return alert('Keranjang kosong!');
        if (!paymentMethod) return alert('Pilih metode pembayaran!');
        if (amountPaid < total) return alert('Jumlah bayar kurang!');

        const transactionData = {
            items: cart.map(item => ({ product_id: item.id, quantity: item.quantity, price: item.price })),
            payment_method: paymentMethod,
            amount_paid: amountPaid,
            customer_name: document.getElementById('customer-name').value || 'Umum',
        };

        try {
            const response = await fetch('/pos/transaction', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify(transactionData)
            });
            const result = await response.json();
            if (response.ok && result.success) {
                closePaymentModal();
                showSuccessModal(result.transaction);
            } else {
                alert(result.message || 'Transaksi gagal!');
            }
        } catch (error) {
            console.error('Transaction error:', error);
            alert('Terjadi kesalahan saat memproses transaksi.');
        }
    }

    function showSuccessModal(transaction) {
        window.currentTransaction = transaction;
        document.getElementById('transaction-id').textContent = transaction.transaction_code;
        document.getElementById('success-total').textContent = formatRupiah(transaction.total_amount);
        document.getElementById('success-change').textContent = formatRupiah(transaction.change_amount);
        document.getElementById('success-modal').classList.remove('hidden');
        startCountdownTimer();
    }

    function closeSuccessModal() {
        if (countdownInterval) clearInterval(countdownInterval);
        document.getElementById('success-modal').classList.add('hidden');
        cart = [];
        updateCartDisplay();
        loadProducts();
    }

    function startCountdownTimer() {
        let timeLeft = 10;
        const countdownEl = document.getElementById('countdown-timer');
        countdownEl.textContent = timeLeft;
        if (countdownInterval) clearInterval(countdownInterval);
        countdownInterval = setInterval(() => {
            timeLeft--;
            countdownEl.textContent = timeLeft;
            if (timeLeft <= 0) {
                clearInterval(countdownInterval);
                closeSuccessModal();
            }
        }, 1000);
    }

    // === PRINTING LOGIC ===
    async function printReceipt() {
        if (!window.currentTransaction) return alert('Data transaksi tidak ditemukan!');
        try {
            if (!navigator.bluetooth) throw new Error('Web Bluetooth tidak didukung di browser ini.');
            await printReceiptToBluetooth();
        } catch (error) {
            console.error('Print error:', error);
            if (confirm('Gagal terhubung ke printer Bluetooth. Cetak menggunakan printer browser?')) {
                printReceiptToBrowser();
            }
        }
    }

    async function printReceiptToBluetooth() {
        try {
            // [FIX] Menggunakan acceptAllDevices: true untuk mempermudah menemukan printer.
            const device = await navigator.bluetooth.requestDevice({
                acceptAllDevices: true,
                optionalServices: ['000018f0-0000-1000-8000-00805f9b34fb'] // Generic printer service UUID
            });
            const server = await device.gatt.connect();
            const service = await server.getPrimaryService('000018f0-0000-1000-8000-00805f9b34fb');
            const characteristic = await service.getCharacteristic('00002af1-0000-1000-8000-00805f9b34fb'); // Generic write characteristic
            const receiptData = generateThermalReceiptData();
            await characteristic.writeValue(receiptData);
            alert('Struk berhasil dikirim ke printer!');
        } catch (error) {
            console.error('Bluetooth print error:', error);
            throw error;
        }
    }

    function generateThermalReceiptData() {
        const tx = window.currentTransaction;
        const now = new Date();
        const ESC = '\x1B', GS = '\x1D';
        let receipt = '';
        receipt += ESC + '@'; // Initialize
        receipt += ESC + 'a' + '\x01'; // Center align
        receipt += ESC + '!' + '\x18'; // Double height & width
        receipt += `${STORE_SETTINGS.store_name}\n`;
        receipt += ESC + '!' + '\x00'; // Normal size
        receipt += `${STORE_SETTINGS.store_address}\n`;
        receipt += `Telp: ${STORE_SETTINGS.store_phone}\n`;
        receipt += '================================\n';
        receipt += ESC + 'a' + '\x00'; // Left align
        receipt += `No: ${tx.transaction_code}\n`;
        receipt += `Tgl: ${now.toLocaleDateString('id-ID')} ${now.toLocaleTimeString('id-ID')}\n`;
        receipt += `Kasir: ${AUTH_USER.name}\n`;
        receipt += '================================\n';
        tx.items.forEach(item => {
            receipt += `${item.product.name}\n`;
            receipt += `  ${item.quantity} x ${formatRupiah(item.price)} = ${formatRupiah(item.quantity * item.price)}\n`;
        });
        receipt += '================================\n';
        receipt += ESC + 'a' + '\x02'; // Right align
        receipt += `Total: ${formatRupiah(tx.total_amount)}\n`;
        // receipt += `Bayar: ${formatRupiah(tx.paid_amount)}\n`;
        receipt += `Bayar: ${formatRupiah(tx.amount_paid)}\n`;
        receipt += `Kembali: ${formatRupiah(tx.change_amount)}\n`;
        receipt += ESC + 'a' + '\x01'; // Center align
        receipt += '================================\n';
        receipt += 'Terima kasih!\n\n\n';
        receipt += GS + 'V' + '\x41' + '\x03'; // Cut paper
        return new TextEncoder().encode(receipt);
    }

    function printReceiptToBrowser() {
        const transaction = window.currentTransaction;
        const printArea = document.getElementById('print-area');
        if (!transaction || !printArea) return;
        const now = new Date();
        const receiptHTML = `
           <div style="font-family: 'Courier New', monospace; font-size: 11px; width: 280px; padding: 10px; color: black;">
                <div style="text-align: center;">
                    <div style="font-size: 16px; font-weight: bold; margin-bottom: 4px;">${STORE_SETTINGS.store_name}</div>
                    <div>${STORE_SETTINGS.store_address}</div>
                    <div>Telp: ${STORE_SETTINGS.store_phone}</div>
                </div>

                <div style="border-top: 1px dashed black; margin: 8px 0;"></div>

                <table style="width: 100%; font-size: 11px;">
                    <tr>
                        <td>No</td>
                        <td>: ${transaction.transaction_code}</td>
                    </tr>
                    <tr>
                        <td>Tgl</td>
                        <td>: ${now.toLocaleDateString('id-ID')} ${now.toLocaleTimeString('id-ID')}</td>
                    </tr>
                    <tr>
                        <td>Kasir</td>
                        <td>: ${AUTH_USER.name}</td>
                    </tr>
                </table>

                <div style="border-top: 1px dashed black; margin: 8px 0;"></div>

                <div>
                    ${transaction.items.map(item => `
                        <div style="margin-bottom: 5px;">
                            <div>${item.product.name}</div>
                            <div style="display: flex; justify-content: space-between;">
                                <span>&nbsp;&nbsp;${item.quantity} x ${formatRupiah(item.price)}</span>
                                <span>${formatRupiah(item.quantity * item.price)}</span>
                            </div>
                        </div>
                    `).join('')}
                </div>

                <div style="border-top: 1px dashed black; margin: 8px 0;"></div>

                <div style="text-align: right;">
                    <div style="display: flex; justify-content: space-between;">
                        <span style="font-weight: bold;">Total:</span>
                        <span style="font-weight: bold;">${formatRupiah(transaction.total_amount)}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span>Bayar:</span>
                        <span>${formatRupiah(transaction.amount_paid)}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span>Kembali:</span>
                        <span>${formatRupiah(transaction.change_amount)}</span>
                    </div>
                </div>

                <div style="border-top: 1px dashed black; margin: 8px 0;"></div>

                <div style="text-align: center; margin-top: 10px;">
                    <div>Terima kasih!</div>
                </div>
            </div>
        `;
        printArea.innerHTML = receiptHTML;
        const cleanup = () => {
            printArea.innerHTML = '';
            window.removeEventListener('afterprint', cleanup);
            closeSuccessModal();
        };
        window.addEventListener('afterprint', cleanup);
        window.print();
    }
</script>
@endsection
