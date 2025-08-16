{{-- @extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <div class="lg:col-span-3">
                <div class="bg-white rounded-lg shadow-sm mb-6 p-4">
                    <div class="flex gap-4">
                        <div class="flex-1 relative">
                            <input type="text" id="product-search"
                                   placeholder="Cari nama atau SKU produk..."
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                   autocomplete="off">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <button onclick="focusSearchInput()" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Scan barcode...
                        </button>
                    </div>

                    <div id="search-results" class="mt-4 space-y-2 max-h-60 overflow-y-auto"></div>
                </div>

                <div class="bg-white rounded-lg">
                    <div class="border-b border-gray-200 mb-6">
                        <nav class="-mb-px flex space-x-8 overflow-x-auto">
                            <button onclick="filterByCategory('all', event)" class="category-tab px-6 py-4 text-sm font-medium text-white bg-teal-600 border-b-2 border-teal-600 whitespace-nowrap active">
                                Semua
                            </button>
                            @foreach($categories as $category)
                                <button onclick="filterByCategory('{{ $category->id }}', event)" class="category-tab px-6 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent hover:border-gray-300 whitespace-nowrap">
                                    {{ $category->name }}
                                </button>
                            @endforeach
                        </nav>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div id="products-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                        <!-- Products will be loaded here -->
                    </div>

                    <div class="flex justify-between items-center mt-6 pt-4 border-t">
                        <div class="flex items-center space-x-4">
                            <span id="pagination-info" class="text-sm text-gray-500">Menampilkan 1 sampai 10 dari 38 hasil</span>
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-gray-500">per halaman</span>
                                <select id="per-page-select" onchange="changePerPage(this.value)" class="border-gray-300 rounded text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                                    <option value="10" selected>10</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                        </div>
                        <div id="pagination-buttons" class="flex space-x-1">
                            <button class="px-3 py-2 text-sm text-gray-500 hover:text-gray-700">‹</button>
                            <button class="px-3 py-2 text-sm bg-teal-600 text-white rounded">1</button>
                            <button class="px-3 py-2 text-sm text-gray-500 hover:text-gray-700">2</button>
                            <button class="px-3 py-2 text-sm text-gray-500 hover:text-gray-700">3</button>
                            <button class="px-3 py-2 text-sm text-gray-500 hover:text-gray-700">4</button>
                            <button class="px-3 py-2 text-sm text-gray-500 hover:text-gray-700">›</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm p-4 sticky top-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Keranjang</h3>
                        <button onclick="clearCart()" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-sm font-medium">
                            Reset
                        </button>
                    </div>

                    <div id="cart-items-container" class="space-y-3 mb-4 max-h-60 overflow-y-auto">
                        <div id="empty-cart" class="text-center text-gray-500 py-8">
                            <svg class="w-12 h-12 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 1.5M7 13l1.5 1.5M17 21a2 2 0 100-4 2 2 0 000 4zM9 21a2 2 0 100-4 2 2 0 000 4z"></path>
                            </svg>
                            Keranjang kosong
                        </div>
                    </div>

                    <div class="border-t pt-4 space-y-2">
                        <div class="flex justify-between text-sm">
                            <span>Subtotal</span>
                            <span id="subtotal">Rp 0</span>
                        </div>
                        <div class="flex justify-between font-bold text-lg">
                            <span>Total</span>
                            <span id="total">Rp 0</span>
                        </div>
                    </div>

                    <button onclick="openPaymentModal()"
                            class="w-full mt-4 bg-teal-600 text-white py-3 rounded-lg hover:bg-teal-700 font-medium flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 1.5M7 13l1.5 1.5M17 21a2 2 0 100-4 2 2 0 000 4zM9 21a2 2 0 100-4 2 2 0 000 4z"></path>
                        </svg>
                        Checkout
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="payment-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
        <div class="text-center mb-6">
            <div class="flex justify-center mb-4">
                <div class="w-16 h-16 bg-blue-600 rounded-lg flex items-center justify-center">
                    <span class="text-white text-2xl">💳</span>
                </div>
                <div class="w-16 h-16 bg-orange-500 rounded-lg flex items-center justify-center ml-2">
                    <span class="text-white text-2xl">💰</span>
                </div>
            </div>
            <div class="flex justify-center space-x-4 mb-4">
                <div class="text-center">
                    <div class="text-sm text-gray-500">Total Bayar</div>
                    <div class="text-2xl font-bold text-blue-600" id="modal-total">Rp 58.500</div>
                </div>
                <div class="text-center">
                    <div class="text-sm text-gray-500">Kembalian</div>
                    <div class="text-2xl font-bold text-orange-500" id="modal-change">Rp 0</div>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Customer</label>
                <input type="text" id="customer-name" placeholder="Umum"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Metode Pembayaran</label>
                <select id="payment-method" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Pilih metode pembayaran</option>
                    <option value="cash">💵 Tunai</option>
                    <option value="card">💳 Kartu Debit/Kredit</option>
                    <option value="ewallet">📱 E-Wallet</option>
                    <option value="transfer">🏦 Transfer Bank</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nominal Bayar</label>
                <input type="number" id="amount-paid" placeholder="100.000"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                       onchange="updateModalPayment()">

                <div class="grid grid-cols-3 gap-2 mt-2">
                    <button type="button" onclick="setQuickAmount(50000)" class="px-3 py-1 text-xs bg-gray-100 rounded hover:bg-gray-200">50.000</button>
                    <button type="button" onclick="setQuickAmount(100000)" class="px-3 py-1 text-xs bg-gray-100 rounded hover:bg-gray-200">100.000</button>
                    <button type="button" onclick="setQuickAmount(150000)" class="px-3 py-1 text-xs bg-gray-100 rounded hover:bg-gray-200">150.000</button>
                    <button type="button" onclick="setQuickAmount(200000)" class="px-3 py-1 text-xs bg-gray-100 rounded hover:bg-gray-200">200.000</button>
                    <button type="button" onclick="setQuickAmount(500000)" class="px-3 py-1 text-xs bg-gray-100 rounded hover:bg-gray-200">500.000</button>
                    <button type="button" onclick="setQuickAmount(1000000)" class="px-3 py-1 text-xs bg-gray-100 rounded hover:bg-gray-200">1.000.000</button>
                </div>
            </div>
        </div>

        <div class="flex space-x-3 mt-6">
            <button onclick="closePaymentModal()"
                    class="flex-1 bg-red-500 text-white py-3 rounded-md hover:bg-red-600 font-medium">
                Batal
            </button>
            <button onclick="processTransaction()"
                    class="flex-1 bg-green-500 text-white py-3 rounded-md hover:bg-green-600 font-medium">
                Bayar
            </button>
        </div>
    </div>
</div>

<div id="success-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
        <div class="text-center">
            <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Pembayaran Berhasil!</h3>
            <p class="text-gray-600 mb-6">Transaksi telah berhasil diproses</p>

            <div class="bg-gray-50 rounded-lg p-4 mb-6 text-left">
                <div class="grid grid-cols-2 gap-2 text-sm">
                    <div class="text-gray-600">No. Transaksi</div>
                    <div class="font-medium" id="transaction-id">TRX32823611</div>
                    <div class="text-gray-600">Total Bayar</div>
                    <div class="font-medium" id="success-total">Rp 100.000</div>
                    <div class="text-gray-600">Kembalian</div>
                    <div class="font-medium text-green-600" id="success-change">Rp 61.500</div>
                </div>
            </div>

            <div class="space-y-3">
                <div class="text-sm text-gray-600 mb-4">Cetak Struk?</div>
                <div class="flex space-x-3">
                    <button onclick="printReceipt()"
                            class="flex-1 bg-green-500 text-white py-3 rounded-md hover:bg-green-600 font-medium">
                        📄 Cetak Struk
                    </button>
                    <button onclick="closeSuccessModal()"
                            class="flex-1 bg-red-500 text-white py-3 rounded-md hover:bg-red-600 font-medium">
                        ✕ Lewati
                    </button>
                </div>
                <div class="text-xs text-gray-500">Modal akan tertutup dalam <span id="countdown-timer" class="font-medium text-blue-600">10</span> detik</div>
            </div>
        </div>
    </div>
</div>

<script>
    var cart = [];
    var productData = [];
    var searchTimeout = null;
    var isScanning = false;
    var categories = [];
    var currentPage = 1;
    var currentCategory = 'all';
    var perPage = 10;

    // Initialize when page loads
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Initializing POS system...');
        loadCategories();
        loadAllProducts();
        setupSearch();
        document.getElementById('product-search').focus();
    });

    // Load categories from database
    async function loadCategories() {
        try {
            const response = await fetch('/pos/categories', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (response.ok) {
                categories = await response.json();
                renderCategoryTabs();
            }
        } catch (error) {
            console.error('Error loading categories:', error);
        }
    }

    // Render category tabs based on database data
    function renderCategoryTabs() {
        const categoryContainer = document.querySelector('.flex.border-b.overflow-x-auto');
        if (!categoryContainer) return;

        let tabsHTML = `
            <button onclick="filterByCategory('all', event)" class="category-tab px-6 py-4 text-sm font-medium text-white bg-teal-600 border-b-2 border-teal-600 whitespace-nowrap active">
                Semua
            </button>
        `;

        categories.forEach(category => {
            tabsHTML += `
                <button onclick="filterByCategory('${category.id}', event)" class="category-tab px-6 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent hover:border-gray-300 whitespace-nowrap">
                    ${category.name}
                </button>
            `;
        });

        categoryContainer.innerHTML = tabsHTML;
    }

    // Load all products for display
    async function loadAllProducts() {
        try {
            const response = await fetch(`/pos/products/search?page=${currentPage}&category=${currentCategory}&per_page=${perPage}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (response.ok) {
                const data = await response.json();
                productData = data.products || data; // Handle both old and new response format
                displayProductsGrid(productData);
                updatePagination(data);
            }
        } catch (error) {
            console.error('Error loading products:', error);
        }
    }

    // Display products in grid
    function displayProductsGrid(products) {
        const gridContainer = document.getElementById('products-grid');

        if (!products || products.length === 0) {
            gridContainer.innerHTML = '<div class="col-span-full text-center text-gray-500 py-8">Tidak ada produk</div>';
            return;
        }

        gridContainer.innerHTML = products.map(product => `
            <div class="bg-white border rounded-lg p-3 hover:shadow-md transition-shadow cursor-pointer"
                 onclick="addToCart(${product.id}, '${product.name.replace(/'/g, "\\'")}', ${product.selling_price}, ${product.stock}, '${product.image || ''}')">
                <div class="aspect-square bg-gray-100 rounded-lg mb-2 flex items-center justify-center overflow-hidden">
                    ${product.image ?
                        `<img src="/storage/${product.image}" alt="${product.name}" class="w-full h-full object-cover">` :
                        `<span class="text-2xl">📦</span>`
                    }
                </div>
                <div class="text-sm font-medium text-gray-900 mb-1 line-clamp-2">${product.name}</div>
                <div class="text-xs text-gray-500 mb-2">Stok: ${product.stock}</div>
                <div class="text-sm font-bold text-teal-600">Rp ${new Intl.NumberFormat('id-ID').format(product.selling_price)}</div>
            </div>
        `).join('');
    }

    // Setup search functionality
    function setupSearch() {
        const searchInput = document.getElementById('product-search');

        // Auto-search as user types
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.trim();

            if (query.length < 2) {
                document.getElementById('search-results').innerHTML = '';
                displayProductsGrid(productData);
                return;
            }

            // Debounce search to avoid too many requests
            searchTimeout = setTimeout(() => {
                searchProduct(query);
            }, 300);
        });

        // Handle barcode scanning (detect rapid input)
        let lastInputTime = 0;
        let barcodeBuffer = '';

        searchInput.addEventListener('keydown', function(e) {
            const currentTime = Date.now();

            // If Enter is pressed and looks like a barcode scan
            if (e.key === 'Enter') {
                e.preventDefault();
                const query = this.value.trim();

                if (query.length >= 8) { // Typical barcode length
                    // This looks like a barcode scan
                    searchProduct(query, true);
                } else if (query.length >= 2) {
                    // Regular search
                    searchProduct(query);
                }
            }

            // Detect rapid typing (barcode scanner characteristic)
            if (currentTime - lastInputTime < 50 && e.key.length === 1) {
                isScanning = true;
                barcodeBuffer += e.key;
            } else if (currentTime - lastInputTime > 100) {
                isScanning = false;
                barcodeBuffer = '';
            }

            lastInputTime = currentTime;
        });

        // Handle barcode scanner input completion
        searchInput.addEventListener('blur', function() {
            if (isScanning && barcodeBuffer.length >= 8) {
                this.value = barcodeBuffer;
                searchProduct(barcodeBuffer, true);
            }
            isScanning = false;
            barcodeBuffer = '';
        });
    }

    // Focus search input (for scan button)
    function focusSearchInput() {
        document.getElementById('product-search').focus();
    }

    // Search products
    async function searchProduct(query = null, isBarcodeScan = false) {
        if (!query) {
            query = document.getElementById('product-search').value;
        }

        if (query.length < 2) {
            document.getElementById('search-results').innerHTML = '';
            loadAllProducts(); // Reload all products
            return;
        }

        try {
            const response = await fetch(`/pos/products/search?q=${encodeURIComponent(query)}&category=${currentCategory}&page=1&per_page=${perPage}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            const products = data.products || data; // Handle both response formats

            displaySearchResults(products, isBarcodeScan);
            displayProductsGrid(products); // Also update main grid

            // If barcode scan and exactly one result, auto-add to cart
            if (isBarcodeScan && products.length === 1) {
                const product = products[0];
                addToCart(product.id, product.name, product.selling_price, product.stock, product.image);
            }
        } catch (error) {
            console.error('Search error:', error);
            document.getElementById('search-results').innerHTML = '<p class="text-red-500 text-sm">Error mencari produk. Silakan coba lagi.</p>';
        }
    }

    // Display search results
    function displaySearchResults(products, isBarcodeScan = false) {
        const resultsDiv = document.getElementById('search-results');

        if (!products || products.length === 0) {
            resultsDiv.innerHTML = '<p class="text-gray-500 text-sm">Produk tidak ditemukan</p>';
            return;
        }

        resultsDiv.innerHTML = products.map((product, index) => `
            <div class="flex justify-between items-center p-3 border rounded-lg hover:bg-gray-50 cursor-pointer ${isBarcodeScan && index === 0 ? 'bg-blue-50 border-blue-300' : ''}"
                 onclick="addToCart(${product.id}, '${product.name.replace(/'/g, "\\'")}', ${product.selling_price}, ${product.stock}, '${product.image || ''}')">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden">
                        ${product.image ?
                            `<img src="/storage/${product.image}" alt="${product.name}" class="w-full h-full object-cover">` :
                            '<span class="text-lg">📦</span>'
                        }
                    </div>
                    <div>
                        <div class="font-medium text-gray-900">${product.name}</div>
                        <div class="text-sm text-gray-500">
                            ${product.barcode ? `Barcode: ${product.barcode} | ` : ''}Stok: ${product.stock} | Rp ${new Intl.NumberFormat('id-ID').format(product.selling_price)}
                        </div>
                    </div>
                </div>
                <button class="px-3 py-1 bg-teal-600 text-white text-sm rounded hover:bg-teal-700">+ Tambah</button>
            </div>
        `).join('');
    }

    // Add product to cart
    function addToCart(id, name, price, stock, image = null) {
        console.log('Adding to cart:', { id, name, price, stock, image }); // Debug log

        // Convert to proper types
        const productId = parseInt(id);
        const productPrice = parseFloat(price);
        const productStock = parseInt(stock);

        const existingItem = cart.find(item => item.id === productId);

        if (existingItem) {
            if (existingItem.quantity < productStock) {
                existingItem.quantity++;
                console.log('Increased quantity for existing item:', existingItem);
            } else {
                alert('Stok tidak mencukupi!');
                return;
            }
        } else {
            const newItem = {
                id: productId,
                name: name,
                price: productPrice,
                quantity: 1,
                stock: productStock,
                image: image
            };
            cart.push(newItem);
            console.log('Added new item to cart:', newItem);
        }

        console.log('Current cart:', cart);
        updateCartDisplay();

        // Clear search
        const searchInput = document.getElementById('product-search');
        const searchResults = document.getElementById('search-results');
        if (searchInput) searchInput.value = '';
        if (searchResults) searchResults.innerHTML = '';
    }

    // Update cart display
    function updateCartDisplay() {
        const cartContainer = document.getElementById('cart-items-container');

        if (cart.length === 0) {
            // Show empty cart message
            cartContainer.innerHTML = `
                <div id="empty-cart" class="text-center text-gray-500 py-8">
                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 1.5M7 13l1.5 1.5M17 21a2 2 0 100-4 2 2 0 000 4zM9 21a2 2 0 100-4 2 2 0 000 4z"></path>
                    </svg>
                    Keranjang kosong
                </div>
            `;
            updateCartTotals();
            return;
        }
        cartContainer.innerHTML = cart.map(item => `
            <div class="flex items-center p-3 bg-gray-50 rounded-lg mb-3">
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mr-3 overflow-hidden">
                    ${item.image ?
                        `<img src="/storage/${item.image}" alt="${item.name}" class="w-full h-full object-cover">` :
                        '<span class="text-lg">📦</span>'
                    }
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-sm font-medium text-gray-900 mb-1">${item.name}</div>
                    <div class="text-xs text-gray-500 mb-2">Rp ${new Intl.NumberFormat('id-ID').format(item.price)}</div>
                    <div class="flex items-center justify-between">
                        <div class="text-xs text-gray-500">Subtotal</div>
                        <div class="text-sm font-medium">Rp ${new Intl.NumberFormat('id-ID').format(item.price * item.quantity)}</div>
                    </div>
                    <div class="flex items-center justify-between mt-2">
                        <div class="flex items-center space-x-1">
                            <button type="button" onclick="decreaseQuantity(${item.id})" class="w-6 h-6 bg-gray-200 rounded text-xs hover:bg-gray-300 flex items-center justify-center">-</button>
                            <span class="w-8 text-center text-sm font-medium">${item.quantity}</span>
                            <button type="button" onclick="increaseQuantity(${item.id})" class="w-6 h-6 bg-teal-600 text-white rounded text-xs hover:bg-teal-700 flex items-center justify-center">+</button>
                        </div>
                        <button type="button" onclick="removeFromCart(${item.id})" class="w-6 h-6 bg-red-500 text-white rounded text-xs hover:bg-red-600 flex items-center justify-center">×</button>
                    </div>
                </div>
            </div>
        `).join('');

        updateCartTotals();
    }

    // Increase quantity
    function increaseQuantity(id) {
        console.log('Increasing quantity for ID:', id);
        const productId = parseInt(id);
        const item = cart.find(item => item.id === productId);
        if (item && item.quantity < item.stock) {
            item.quantity++;
            console.log('Quantity increased:', item);
            updateCartDisplay();
        } else if (item) {
            alert('Stok tidak mencukupi!');
        } else {
            console.log('Item not found in cart');
        }
    }

    // Decrease quantity
    function decreaseQuantity(id) {
        console.log('Decreasing quantity for ID:', id);
        const productId = parseInt(id);
        const item = cart.find(item => item.id === productId);
        if (item && item.quantity > 1) {
            item.quantity--;
            console.log('Quantity decreased:', item);
            updateCartDisplay();
        } else {
            console.log('Cannot decrease quantity or item not found');
        }
    }

    // Remove from cart
    function removeFromCart(id) {
        console.log('Removing from cart ID:', id);
        const productId = parseInt(id);
        const initialLength = cart.length;
        cart = cart.filter(item => item.id !== productId);
        console.log('Cart length changed from', initialLength, 'to', cart.length);
        updateCartDisplay();
    }

    // Update cart totals
    function updateCartTotals() {
        const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);

        document.getElementById('subtotal').textContent = `Rp ${new Intl.NumberFormat('id-ID').format(subtotal)}`;
        document.getElementById('total').textContent = `Rp ${new Intl.NumberFormat('id-ID').format(subtotal)}`;
    }

    // Clear cart
    function clearCart() {
        cart = [];
        updateCartDisplay();
    }

    // Open payment modal
    function openPaymentModal() {
        if (cart.length === 0) {
            alert('Keranjang kosong!');
            return;
        }

        const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        document.getElementById('modal-total').textContent = `Rp ${new Intl.NumberFormat('id-ID').format(total)}`;
        document.getElementById('amount-paid').value = total;

        // Calculate initial change (should be 0 if amount paid equals total)
        updateModalPayment();

        document.getElementById('payment-modal').classList.remove('hidden');
    }

    // Close payment modal
    function closePaymentModal() {
        document.getElementById('payment-modal').classList.add('hidden');
    }

    // Set quick amount
    function setQuickAmount(amount) {
        document.getElementById('amount-paid').value = amount;
        updateModalPayment();
    }

    // Update pagination display
    function updatePagination(data) {
        if (!data.total) return; // Handle old response format

        // Update pagination info
        const paginationInfo = document.getElementById('pagination-info');
        if (paginationInfo) {
            const start = ((data.current_page - 1) * data.per_page) + 1;
            const end = Math.min(data.current_page * data.per_page, data.total);
            paginationInfo.textContent = `Menampilkan ${start} sampai ${end} dari ${data.total} hasil`;
        }

        // Update per page select
        const perPageSelect = document.getElementById('per-page-select');
        if (perPageSelect) {
            perPageSelect.value = data.per_page;
        }

        // Update pagination buttons
        const paginationButtons = document.getElementById('pagination-buttons');
        if (!paginationButtons) return;

        let buttonsHTML = '';

        // Previous button
        if (data.current_page > 1) {
            buttonsHTML += `<button onclick="changePage(${data.current_page - 1})" class="px-3 py-2 text-sm text-gray-500 hover:text-gray-700">‹</button>`;
        }

        // Page numbers (show max 5 pages)
        const maxPages = Math.min(5, data.last_page);
        let startPage = Math.max(1, data.current_page - 2);
        let endPage = Math.min(data.last_page, startPage + maxPages - 1);

        if (endPage - startPage < maxPages - 1) {
            startPage = Math.max(1, endPage - maxPages + 1);
        }

        for (let i = startPage; i <= endPage; i++) {
            if (i === data.current_page) {
                buttonsHTML += `<button class="px-3 py-2 text-sm bg-teal-600 text-white rounded">${i}</button>`;
            } else {
                buttonsHTML += `<button onclick="changePage(${i})" class="px-3 py-2 text-sm text-gray-500 hover:text-gray-700">${i}</button>`;
            }
        }

        // Next button
        if (data.current_page < data.last_page) {
            buttonsHTML += `<button onclick="changePage(${data.current_page + 1})" class="px-3 py-2 text-sm text-gray-500 hover:text-gray-700">›</button>`;
        }

        paginationButtons.innerHTML = buttonsHTML;
    }

    // Change page
    function changePage(page) {
        currentPage = page;
        loadAllProducts();
    }

    // Filter products by category
    function filterByCategory(category, event) {
        // Update active tab
        document.querySelectorAll('.category-tab').forEach(tab => {
            tab.classList.remove('active', 'text-white', 'bg-teal-600', 'border-teal-600');
            tab.classList.add('text-gray-500', 'border-transparent');
        });

        // Add active classes to the clicked button
        if (event && event.target) {
            event.target.classList.add('active', 'text-white', 'bg-teal-600', 'border-teal-600');
            event.target.classList.remove('text-gray-500', 'border-transparent');
        }

        // Update current category and reset page
        currentCategory = category;
        currentPage = 1;

        // Load products with new filter
        loadAllProducts();
    }

    // Load all products
    async function loadAllProducts() {
        try {
            const response = await fetch(`/pos/products/search?page=${currentPage}&category=${currentCategory}&per_page=${perPage}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            displayProductsGrid(data.products || data);
            updatePagination(data);

        } catch (error) {
            console.error('Load products error:', error);
            document.getElementById('products-grid').innerHTML = '<p class="text-red-500 text-center col-span-full">Error memuat produk. Silakan refresh halaman.</p>';
        }
    }



    // Load categories
    async function loadCategories() {
        try {
            const response = await fetch('/pos/categories', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const categories = await response.json();
            console.log('Categories loaded:', categories);

        } catch (error) {
            console.error('Load categories error:', error);
        }
    }

    // Change per page setting
    function changePerPage(newPerPage) {
        perPage = parseInt(newPerPage);
        currentPage = 1; // Reset to first page

        // Update the select value to reflect the change
        const perPageSelect = document.getElementById('per-page-select');
        if (perPageSelect) {
            perPageSelect.value = newPerPage;
        }

        loadAllProducts();
    }

    // Update modal payment display
    function updateModalPayment() {
        const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        const amount = parseFloat(document.getElementById('amount-paid').value) || 0;
        const change = Math.max(0, amount - total);
        document.getElementById('modal-change').textContent = `Rp ${new Intl.NumberFormat('id-ID').format(change)}`;
    }

    // Process transaction
    async function processTransaction() {
        if (cart.length === 0) {
            alert('Keranjang kosong!');
            return;
        }

        const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        const amountPaid = parseFloat(document.getElementById('amount-paid').value) || 0;
        const paymentMethod = document.getElementById('payment-method').value;
        const customerName = document.getElementById('customer-name').value || 'Umum';

        if (amountPaid < total) {
            alert('Jumlah bayar kurang!');
            return;
        }

        if (!paymentMethod || paymentMethod === '') {
            alert('Pilih metode pembayaran!');
            return;
        }

        const transactionData = {
            items: cart.map(item => ({
                product_id: item.id,
                quantity: item.quantity
            })),
            payment_method: paymentMethod,
            amount_paid: amountPaid,
            discount: 0,
            customer_name: customerName
        };

        try {
            console.log('Sending transaction data:', transactionData);

            const response = await fetch('/pos/transaction', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify(transactionData)
            });

            console.log('Response status:', response.status);
            const result = await response.json();
            console.log('Response data:', result);

            if (response.ok && result.success) {
                closePaymentModal();
                clearCart();

                // Show SweetAlert toast notification
                Swal.fire({
                    icon: 'success',
                    title: 'Order berhasil disimpan',
                    text: `Transaksi ${result.transaction.transaction_code} berhasil diproses`,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });

                // Show success modal with countdown
                showSuccessModal(result.transaction, total, amountPaid);
            } else {
                console.error('Transaction failed:', result);
                Swal.fire({
                    icon: 'error',
                    title: 'Transaksi Gagal!',
                    text: result.message || 'Transaksi gagal!',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true
                });
            }
        } catch (error) {
            console.error('Transaction error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Terjadi kesalahan! Periksa console untuk detail.',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true
            });
        }
    }

    // Show success modal
    function showSuccessModal(transaction, total, amountPaid) {
        var change = amountPaid - total;

        document.getElementById('transaction-id').textContent = transaction.transaction_code || 'TRX' + Date.now();
        document.getElementById('success-total').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        document.getElementById('success-change').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(change);

        // Store transaction data for printing
        window.currentTransaction = {
            transaction_code: transaction.transaction_code,
            items: transaction.items,
            user: transaction.user,
            total: total,
            amountPaid: amountPaid,
            change: change
        };

        document.getElementById('success-modal').classList.remove('hidden');

        // Start countdown timer for auto-close
        startCountdownTimer();
    }

    // Start countdown timer for auto-close modal
    let countdownInterval = null;

    function startCountdownTimer() {
        let timeLeft = 10;
        const countdownElement = document.getElementById('countdown-timer');

        // Clear any existing countdown
        if (countdownInterval) {
            clearInterval(countdownInterval);
        }

        // Update countdown every second
        countdownInterval = setInterval(function() {
            timeLeft--;
            countdownElement.textContent = timeLeft;

            // Change color as time runs out
            if (timeLeft <= 3) {
                countdownElement.className = 'font-medium text-red-600';
            } else if (timeLeft <= 5) {
                countdownElement.className = 'font-medium text-orange-600';
            } else {
                countdownElement.className = 'font-medium text-blue-600';
            }

            // Auto-close when countdown reaches 0
            if (timeLeft <= 0) {
                clearInterval(countdownInterval);
                closeSuccessModal();
            }
        }, 1000);
    }

    // Close success modal
    function closeSuccessModal() {
        // Clear countdown timer
        if (countdownInterval) {
            clearInterval(countdownInterval);
            countdownInterval = null;
        }

        // Reset countdown display
        const countdownElement = document.getElementById('countdown-timer');
        if (countdownElement) {
            countdownElement.textContent = '10';
            countdownElement.className = 'font-medium text-blue-600';
        }

        document.getElementById('success-modal').classList.add('hidden');
    }

    // Print receipt
    async function printReceipt() {
        if (!window.currentTransaction) {
            alert('Data transaksi tidak ditemukan!');
            return;
        }

        try {
            // Check if Web Bluetooth is supported
            if (!navigator.bluetooth) {
                // Fallback to browser print
                printReceiptToBrowser();
                return;
            }

            // Try to connect to thermal printer via Bluetooth
            await printReceiptToBluetooth();

        } catch (error) {
            console.error('Print error:', error);

            // Fallback to browser print if Bluetooth fails
            if (confirm('Gagal terhubung ke printer Bluetooth. Cetak menggunakan printer browser?')) {
                printReceiptToBrowser();
            }
        }
    }

    // Print receipt to Bluetooth thermal printer
    async function printReceiptToBluetooth() {
        try {
            // Request Bluetooth device
            const device = await navigator.bluetooth.requestDevice({
                filters: [
                    { services: ['000018f0-0000-1000-8000-00805f9b34fb'] }, // Generic printer service
                    { namePrefix: 'POS' },
                    { namePrefix: 'Thermal' },
                    { namePrefix: 'Receipt' }
                ],
                optionalServices: ['000018f0-0000-1000-8000-00805f9b34fb']
            });

            console.log('Connecting to printer:', device.name);

            // Connect to GATT server
            const server = await device.gatt.connect();

            // Get printer service (this may vary by printer model)
            const service = await server.getPrimaryService('000018f0-0000-1000-8000-00805f9b34fb');

            // Get write characteristic
            const characteristic = await service.getCharacteristic('00002af1-0000-1000-8000-00805f9b34fb');

            // Generate receipt content for thermal printer
            const receiptData = generateThermalReceiptData();

            // Send data to printer
            await characteristic.writeValue(receiptData);

            alert('Struk berhasil dicetak!');
            closeSuccessModal();

        } catch (error) {
            console.error('Bluetooth print error:', error);
            throw error;
        }
    }

    // Generate thermal printer data (ESC/POS commands)
    function generateThermalReceiptData() {
        var transaction = window.currentTransaction;
        var now = new Date();

        // ESC/POS commands
        var ESC = '\x1B';
        var GS = '\x1D';

        var receipt = '';

        // Initialize printer
        receipt += ESC + '@'; // Initialize
        receipt += ESC + 'a' + '\x01'; // Center align

        // Header
        receipt += ESC + '!' + '\x18'; // Double height and width
        receipt += '{{ $storeSettings->store_name }}\n';
        receipt += ESC + '!' + '\x00'; // Normal size
        receipt += '{{ $storeSettings->store_address ?? "Alamat Toko" }}\n';
        receipt += 'Telp: {{ $storeSettings->store_phone ?? "Nomor Telepon" }}\n';
        receipt += '================================\n';

        // Transaction info
        receipt += ESC + 'a' + '\x00'; // Left align
        receipt += 'No. Transaksi: ' + transaction.transaction_code + '\n';
        receipt += 'Tanggal: ' + now.toLocaleDateString('id-ID') + '\n';
        receipt += 'Waktu: ' + now.toLocaleTimeString('id-ID') + '\n';
        receipt += 'Kasir: ' + (transaction.user ? transaction.user.name : 'Admin') + '\n';
        receipt += '================================\n';

        // Items
        if (transaction.items && transaction.items.length > 0) {
            for (var i = 0; i < transaction.items.length; i++) {
                var item = transaction.items[i];
                var product = item.product || item;
                var name = product.name || 'Produk';
                var qty = item.quantity || 1;
                var price = item.price || product.selling_price || 0;
                var subtotal = qty * price;

                receipt += name + '\n';
                receipt += qty + ' x ' + formatRupiah(price) + ' = ' + formatRupiah(subtotal) + '\n';
            }
        } else {
            // Fallback if items not available
            receipt += 'Detail item tidak tersedia\n';
        }

        receipt += '================================\n';

        // Totals
        receipt += ESC + 'a' + '\x02'; // Right align
        receipt += 'Subtotal: ' + formatRupiah(transaction.total) + '\n';
        receipt += 'Total: ' + formatRupiah(transaction.total) + '\n';
        receipt += 'Bayar: ' + formatRupiah(transaction.amountPaid) + '\n';
        receipt += 'Kembalian: ' + formatRupiah(transaction.change) + '\n';

        receipt += ESC + 'a' + '\x01'; // Center align
        receipt += '================================\n';
        receipt += 'Terima kasih atas kunjungan Anda\n';
        receipt += 'Barang yang sudah dibeli\n';
        receipt += 'tidak dapat dikembalikan\n';
        receipt += '\n\n\n';

        // Cut paper
        receipt += GS + 'V' + '\x41' + '\x03';

        // Convert to Uint8Array
        var encoder = new TextEncoder();
        return encoder.encode(receipt);
    }

    // Print receipt to browser (fallback)
    function printReceiptToBrowser() {
        var transaction = window.currentTransaction;
        var now = new Date();

        // Create print window
        var printWindow = window.open('', '_blank', 'width=300,height=600');

        // Build receipt HTML safely
        var receiptHTML = '<!DOCTYPE html><html><head><title>Struk Pembayaran</title>';
        receiptHTML += '<style>';
        receiptHTML += 'body { font-family: "Courier New", monospace; font-size: 12px; margin: 0; padding: 10px; width: 280px; }';
        receiptHTML += '.center { text-align: center; }';
        receiptHTML += '.bold { font-weight: bold; }';
        receiptHTML += '.large { font-size: 16px; }';
        receiptHTML += '.separator { border-top: 1px dashed #000; margin: 5px 0; }';
        receiptHTML += '.item-row { display: flex; justify-content: space-between; }';
        receiptHTML += '@media print { body { width: auto; } }';
        receiptHTML += '</style></head><body>';

        // Header
        receiptHTML += '<div class="center bold large">{{ $storeSettings->store_name }}</div>';
        receiptHTML += '<div class="center">{{ $storeSettings->store_address ?? "Alamat Toko" }}</div>';
        receiptHTML += '<div class="center">Telp: {{ $storeSettings->store_phone ?? "Nomor Telepon" }}</div>';
        receiptHTML += '<div class="separator"></div>';

        // Transaction info
        receiptHTML += '<div>No. Transaksi: ' + transaction.transaction_code + '</div>';
        receiptHTML += '<div>Tanggal: ' + now.toLocaleDateString('id-ID') + '</div>';
        receiptHTML += '<div>Waktu: ' + now.toLocaleTimeString('id-ID') + '</div>';
        receiptHTML += '<div>Kasir: ' + (transaction.user ? transaction.user.name : 'Admin') + '</div>';
        receiptHTML += '<div class="separator"></div>';

        // Items
        if (transaction.items && transaction.items.length > 0) {
            for (var i = 0; i < transaction.items.length; i++) {
                var item = transaction.items[i];
                var product = item.product || item;
                var name = product.name || 'Produk';
                var qty = item.quantity || 1;
                var price = item.price || product.selling_price || 0;
                var subtotal = qty * price;

                receiptHTML += '<div>' + name + '</div>';
                receiptHTML += '<div class="item-row">';
                receiptHTML += '<span>' + qty + ' x ' + formatRupiah(price) + '</span>';
                receiptHTML += '<span>' + formatRupiah(subtotal) + '</span>';
                receiptHTML += '</div>';
            }
        } else {
            receiptHTML += '<div>Detail item tidak tersedia</div>';
        }

        receiptHTML += '<div class="separator"></div>';

        // Totals
        receiptHTML += '<div class="item-row"><span>Subtotal:</span><span>' + formatRupiah(transaction.total) + '</span></div>';
        receiptHTML += '<div class="item-row bold"><span>Total:</span><span>' + formatRupiah(transaction.total) + '</span></div>';
        receiptHTML += '<div class="item-row"><span>Bayar:</span><span>' + formatRupiah(transaction.amountPaid) + '</span></div>';
        receiptHTML += '<div class="item-row"><span>Kembalian:</span><span>' + formatRupiah(transaction.change) + '</span></div>';

        // Footer
        receiptHTML += '<div class="separator"></div>';
        receiptHTML += '<div class="center">Terima kasih atas kunjungan Anda</div>';
        receiptHTML += '<div class="center">Barang yang sudah dibeli</div>';
        receiptHTML += '<div class="center">tidak dapat dikembalikan</div>';

        // Script
        receiptHTML += '<scr' + 'ipt>window.onload = function() { window.print(); setTimeout(function() { window.close(); }, 1000); }</scr' + 'ipt>';
        receiptHTML += '</body></html>';

        printWindow.document.write(receiptHTML);
        printWindow.document.close();

        // Close success modal after printing
        setTimeout(function() {
            closeSuccessModal();
        }, 2000);
    }

    // Format rupiah helper
    function formatRupiah(amount) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
    }

    // Initialize POS system when page loads
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Initializing POS system...');

        // Setup search functionality
        setupSearch();

        // Load initial data
        loadCategories();
        loadAllProducts();

        // Initialize cart display
        updateCartDisplay();
    });
</script>
@endsection --}}

{{-- ========================================================================================= --}}

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
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

            {{-- Kolom Kiri (Produk & Kategori) --}}
            <div class="lg:col-span-3">

                {{-- Area Pencarian --}}
                <div class="bg-white rounded-lg shadow-sm mb-6 p-4">
                    {{-- [RESPONSIVE] Dibuat vertikal di layar kecil (flex-col) dan horizontal di layar lebih besar (sm:flex-row). --}}
                    <div class="flex flex-col sm:flex-row gap-4">
                        <div class="flex-1 relative">
                            <input type="text" id="product-search" placeholder="Cari nama atau SKU produk..." class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500" autocomplete="off">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                        </div>
                        <button onclick="focusSearchInput()" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Scan barcode...
                        </button>
                    </div>
                    <div id="search-results" class="mt-4 space-y-2 max-h-60 overflow-y-auto"></div>
                </div>

                {{-- Tab Kategori --}}
                <div class="bg-white rounded-lg mb-6">
                    <div class="border-b border-gray-200">
                        {{-- [FIX] Konten tab kategori diisi oleh JavaScript untuk menghindari duplikasi render. --}}
                        <nav id="category-tabs-container" class="-mb-px flex space-x-8 overflow-x-auto"></nav>
                    </div>
                </div>

                {{-- Daftar Produk --}}
                <div class="bg-white rounded-lg shadow-sm p-6">
                    {{-- [RESPONSIVE] Grid produk beradaptasi di berbagai ukuran layar untuk tampilan optimal. --}}
                    <div id="products-grid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 min-h-[300px]">
                        {{-- Produk akan dimuat di sini oleh JavaScript --}}
                    </div>

                    {{-- Paginasi --}}
                    <div class="flex flex-col sm:flex-row justify-between items-center mt-6 pt-4 border-t gap-4">
                        <div class="flex items-center space-x-4">
                            <span id="pagination-info" class="text-sm text-gray-500"></span>
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-gray-500">per halaman</span>
                                <select id="per-page-select" onchange="changePerPage(this.value)" class="border-gray-300 rounded text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
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

            {{-- Kolom Kanan (Keranjang) --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm p-4 sticky top-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Keranjang</h3>
                        <button onclick="clearCart()" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-sm font-medium">Reset</button>
                    </div>
                    <div id="cart-items-container" class="space-y-3 mb-4 max-h-80 overflow-y-auto">
                        {{-- Item keranjang akan diisi di sini --}}
                    </div>
                    <div class="border-t pt-4 space-y-2">
                        <div class="flex justify-between text-sm"><span>Subtotal</span><span id="subtotal">Rp 0</span></div>
                        <div class="flex justify-between font-bold text-lg"><span>Total</span><span id="total">Rp 0</span></div>
                    </div>
                    <button id="checkout-button" onclick="openPaymentModal()" class="w-full mt-4 bg-teal-600 text-white py-3 rounded-lg hover:bg-teal-700 font-medium flex items-center justify-center gap-2 disabled:bg-gray-400" disabled>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 1.5M7 13l1.5 1.5M17 21a2 2 0 100-4 2 2 0 000 4zM9 21a2 2 0 100-4 2 2 0 000 4z"></path></svg>
                        Checkout
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ================================= MODALS ================================= --}}

{{-- Modal Pembayaran --}}
{{-- <div id="payment-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
        <div class="text-center mb-6">
            <div class="flex justify-center mb-4">
                <div class="w-16 h-16 bg-blue-600 rounded-lg flex items-center justify-center">
                    <span class="text-white text-2xl">💳</span>
                </div>
                <div class="w-16 h-16 bg-orange-500 rounded-lg flex items-center justify-center ml-2">
                    <span class="text-white text-2xl">💰</span>
                </div>
            </div>
             <div class="flex justify-center space-x-4 mb-4">
                <div class="text-center"><div class="text-sm text-gray-500">Total Bayar</div><div class="text-2xl font-bold text-blue-600" id="modal-total">Rp 0</div></div>
                <div class="text-center"><div class="text-sm text-gray-500">Kembalian</div><div class="text-2xl font-bold text-orange-500" id="modal-change">Rp 0</div></div>
            </div>
        </div>
        <div class="space-y-4">
            <div><label for="customer-name" class="block text-sm font-medium text-gray-700 mb-2">Nama Customer</label><input type="text" id="customer-name" placeholder="Umum" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></div>
            <div>
                <label for="payment-method" class="block text-sm font-medium text-gray-700 mb-2">Metode Pembayaran</label>
                <select id="payment-method" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Pilih metode pembayaran</option>
                    <option value="cash">💵 Tunai</option>
                    <option value="card">💳 Kartu Debit/Kredit</option>
                    <option value="ewallet">📱 E-Wallet</option>
                    <option value="transfer">🏦 Transfer Bank</option>
                </select>
            </div>
            <div>
                <label for="amount-paid" class="block text-sm font-medium text-gray-700 mb-2">Nominal Bayar</label>
                <input type="number" id="amount-paid" placeholder="0" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" oninput="updateModalPayment()">
                <div class="grid grid-cols-3 gap-2 mt-2">
                    <button type="button" onclick="setQuickAmount(50000)" class="px-3 py-1 text-xs bg-gray-100 rounded hover:bg-gray-200">50.000</button>
                    <button type="button" onclick="setQuickAmount(100000)" class="px-3 py-1 text-xs bg-gray-100 rounded hover:bg-gray-200">100.000</button>
                    <button type="button" onclick="setQuickAmount(150000)" class="px-3 py-1 text-xs bg-gray-100 rounded hover:bg-gray-200">150.000</button>
                    <button type="button" onclick="setQuickAmount(200000)" class="px-3 py-1 text-xs bg-gray-100 rounded hover:bg-gray-200">200.000</button>
                    <button type="button" onclick="setQuickAmount(500000)" class="px-3 py-1 text-xs bg-gray-100 rounded hover:bg-gray-200">500.000</button>
                    <button type="button" onclick="setQuickAmount(1000000)" class="px-3 py-1 text-xs bg-gray-100 rounded hover:bg-gray-200">1.000.000</button>
                </div>
            </div>
        </div>
        <div class="flex space-x-3 mt-6">
            <button onclick="closePaymentModal()" class="flex-1 bg-red-500 text-white py-3 rounded-md hover:bg-red-600 font-medium">Batal</button>
            <button onclick="processTransaction()" class="flex-1 bg-teal-600 text-white py-3 rounded-md hover:bg-teal-700 font-medium">Bayar</button>
        </div>
    </div>
</div> --}}
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

    // async function loadProducts() {
    //     const query = document.getElementById('product-search').value.trim();
    //     const url = `/pos/products/search?q=${encodeURIComponent(query)}&page=${currentPage}&category=${currentCategory}&per_page=${perPage}`;
    //     const data = await fetchData(url);
    //     if (data) {
    //         // displayProductsGrid(data.data || []);
    //         displayProductsGrid(data.data || data.products || data || []);
    //         updatePagination(data);
    //     } else {
    //         document.getElementById('products-grid').innerHTML = '<p class="text-red-500 text-center col-span-full">Error memuat produk.</p>';
    //     }
    // }

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

    function focusSearchInput() {
        document.getElementById('product-search').focus();
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
        alert('Membuka dialog cetak browser sebagai alternatif.');
        // Implementasi fallback cetak ke browser bisa ditambahkan di sini jika perlu.
        // Untuk saat ini, window.print() sederhana sudah cukup.
        window.print();
    }
</script>
@endsection
