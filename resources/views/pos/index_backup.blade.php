@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <div class="w-8 h-8 bg-teal-600 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold">K</span>
                    </div>
                    <div class="w-8 h-8 bg-teal-600 rounded-lg flex items-center justify-center">
                        <span class="text-white">⊞</span>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600">Kasir</span>
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                        <span class="text-white">👤</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Main Content Area -->
            <div class="lg:col-span-3">
                <!-- Search Bar -->
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
                        <button class="px-4 py-3 bg-teal-600 text-white rounded-lg hover:bg-teal-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Search Results -->
                    <div id="search-results" class="mt-4 space-y-2 max-h-60 overflow-y-auto"></div>
                </div>

                <!-- Category Tabs -->
                <div class="bg-white rounded-lg shadow-sm mb-6">
                    <div class="flex border-b overflow-x-auto">
                        <button onclick="filterByCategory('all')" class="category-tab px-6 py-4 text-sm font-medium text-white bg-teal-600 border-b-2 border-teal-600 whitespace-nowrap active">
                            Semua
                        </button>
                        <button onclick="filterByCategory('makanan-ringan')" class="category-tab px-6 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent hover:border-gray-300 whitespace-nowrap">
                            Makanan Ringan
                        </button>
                        <button onclick="filterByCategory('minuman')" class="category-tab px-6 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent hover:border-gray-300 whitespace-nowrap">
                            Minuman
                        </button>
                        <button onclick="filterByCategory('alat-tulis')" class="category-tab px-6 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent hover:border-gray-300 whitespace-nowrap">
                            Alat Tulis Kantor (ATK)
                        </button>
                        <button onclick="filterByCategory('kebersihan')" class="category-tab px-6 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent hover:border-gray-300 whitespace-nowrap">
                            Produk Kebersihan
                        </button>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div id="products-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                        <!-- Products will be loaded here -->
                    </div>
                    
                    <!-- Pagination -->
                    <div class="flex justify-between items-center mt-6 pt-4 border-t">
                        <span class="text-sm text-gray-500">Menampilkan 1 sampai 10 dari 38 hasil</span>
                        <div class="flex space-x-1">
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

            <!-- Cart Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm p-4 sticky top-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Keranjang</h3>
                        <button onclick="clearCart()" class="text-red-600 hover:text-red-800 text-sm">Reset</button>
                    </div>
                    
                    <!-- Cart Items -->
                    <div id="cart-items-container" class="space-y-3 mb-4 max-h-60 overflow-y-auto">
                        <div id="empty-cart" class="text-center text-gray-500 py-8">
                            <svg class="w-12 h-12 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 1.5M7 13l1.5 1.5M17 21a2 2 0 100-4 2 2 0 000 4zM9 21a2 2 0 100-4 2 2 0 000 4z"></path>
                            </svg>
                            Keranjang kosong
                        </div>
                    </div>
                    
                    <!-- Cart Summary -->
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
                    
                    <!-- Checkout Button -->
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

<!-- Payment Modal -->
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
                
                <!-- Quick Amount Buttons -->
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

<!-- Success Modal -->
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
                <div class="text-xs text-gray-500">Modal akan tertutup dalam 3 detik</div>
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
        <button onclick="filterByCategory('all')" class="category-tab px-6 py-4 text-sm font-medium text-white bg-teal-600 border-b-2 border-teal-600 whitespace-nowrap active">
            Semua
        </button>
    `;
    
    categories.forEach(category => {
        tabsHTML += `
            <button onclick="filterByCategory('${category.id}')" class="category-tab px-6 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent hover:border-gray-300 whitespace-nowrap">
                ${category.name}
            </button>
        `;
    });
    
    categoryContainer.innerHTML = tabsHTML;
}

// Load all products for display
async function loadAllProducts() {
    try {
        const response = await fetch(`/pos/products/search?page=${currentPage}&category=${currentCategory}`, {
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
             onclick="addToCart(${product.id}, '${product.name.replace(/'/g, "\\'")}', ${product.selling_price}, ${product.stock})">
            <div class="aspect-square bg-gray-100 rounded-lg mb-2 flex items-center justify-center">
                <span class="text-2xl">📦</span>
            </div>
            <div class="text-sm font-medium text-gray-900 mb-1 line-clamp-2">${product.name}</div>
            <div class="text-xs text-gray-500 mb-2">Stok: ${product.stock}</div>
            <div class="text-sm font-bold text-teal-600">Rp ${new Intl.NumberFormat('id-ID').format(product.selling_price)}</div>
            <div class="text-xs text-gray-400">(${product.stock > 0 ? product.stock : '0'})</div>
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
        const response = await fetch(`/pos/products/search?q=${encodeURIComponent(query)}&category=${currentCategory}&page=1`, {
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
            addToCart(product.id, product.name, product.selling_price, product.stock);
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
             onclick="addToCart(${product.id}, '${product.name.replace(/'/g, "\\'")}', ${product.selling_price}, ${product.stock})">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                    <span class="text-lg">📦</span>
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
function addToCart(id, name, price, stock) {
    console.log('Adding to cart:', { id, name, price, stock }); // Debug log
    
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
            stock: productStock 
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
            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                <span class="text-lg">📦</span>
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
    
    const paginationContainer = document.querySelector('.flex.justify-between.items-center.mt-6.pt-4.border-t');
    if (!paginationContainer) return;
    
    const start = ((data.current_page - 1) * data.per_page) + 1;
    const end = Math.min(data.current_page * data.per_page, data.total);
    
    let paginationHTML = `
        <span class="text-sm text-gray-500">Menampilkan ${start} sampai ${end} dari ${data.total} hasil</span>
        <div class="flex space-x-1">
    `;
    
    // Previous button
    if (data.current_page > 1) {
        paginationHTML += `<button onclick="changePage(${data.current_page - 1})" class="px-3 py-2 text-sm text-gray-500 hover:text-gray-700">‹</button>`;
    }
    
    // Page numbers
    for (let i = 1; i <= data.last_page; i++) {
        if (i === data.current_page) {
            paginationHTML += `<button class="px-3 py-2 text-sm bg-teal-600 text-white rounded">${i}</button>`;
        } else {
            paginationHTML += `<button onclick="changePage(${i})" class="px-3 py-2 text-sm text-gray-500 hover:text-gray-700">${i}</button>`;
        }
    }
    
    // Next button
    if (data.current_page < data.last_page) {
        paginationHTML += `<button onclick="changePage(${data.current_page + 1})" class="px-3 py-2 text-sm text-gray-500 hover:text-gray-700">›</button>`;
    }
    
    paginationHTML += '</div>';
    paginationContainer.innerHTML = paginationHTML;
}

// Change page
function changePage(page) {
    currentPage = page;
    loadAllProducts();
}

// Filter products by category
function filterByCategory(category) {
    // Update active tab
    document.querySelectorAll('.category-tab').forEach(tab => {
        tab.classList.remove('active', 'text-white', 'bg-teal-600', 'border-teal-600');
        tab.classList.add('text-gray-500', 'border-transparent');
    });
    
    event.target.classList.add('active', 'text-white', 'bg-teal-600', 'border-teal-600');
    event.target.classList.remove('text-gray-500', 'border-transparent');
    
    // Update current category and reset page
    currentCategory = category;
    currentPage = 1;
    
    // Load products with new filter
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
        
        const response = await fetch('/pos', {
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
            showSuccessModal(result.transaction, total, amountPaid);
            clearCart();
        } else {
            console.error('Transaction failed:', result);
            alert(result.message || 'Transaksi gagal!');
        }
    } catch (error) {
        console.error('Transaction error:', error);
        alert('Terjadi kesalahan! Periksa console untuk detail.');
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
    
    // Remove auto-close - modal will only close when user clicks button
}

// Close success modal
function closeSuccessModal() {
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
    receipt += 'MINIMARKET POS\n';
    receipt += ESC + '!' + '\x00'; // Normal size
    receipt += 'Jl. Contoh No. 123\n';
    receipt += 'Telp: (021) 1234567\n';
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
    receiptHTML += '<div class="center bold large">MINIMARKET POS</div>';
    receiptHTML += '<div class="center">Jl. Contoh No. 123</div>';
    receiptHTML += '<div class="center">Telp: (021) 1234567</div>';
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
    receiptHTML += '<script>window.onload = function() { window.print(); setTimeout(function() { window.close(); }, 1000); }</script>';
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

// Clear cart
function clearCart() {
    cart = [];
    updateCartDisplay();
    
    // Safely clear form fields if they exist
    var amountPaidField = document.getElementById('amount-paid');
    if (amountPaidField) {
        amountPaidField.value = '';
    }
    
    var productSearchField = document.getElementById('product-search');
    if (productSearchField) {
        productSearchField.focus();
    }
}

// Setup search functionality
function setupSearch() {
    // Enter key search
    document.getElementById('product-search').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            searchProduct();
        }
    });
    
    // Auto-search with debouncing
    var searchTimeout;
    var lastInputTime = 0;
    var searchInput = document.getElementById('product-search');
    
    searchInput.addEventListener('input', function(e) {
        clearTimeout(searchTimeout);
        var query = e.target.value;
        
        // Detect barcode scanning (rapid input)
        if (query.length > 8 && Date.now() - lastInputTime < 100) {
            searchProduct(query, true);
            return;
        }
        
        // Regular search with debounce
        searchTimeout = setTimeout(function() {
            if (query.length >= 2) {
                searchProduct(query);
            } else if (query.length === 0) {
                clearSearchResults();
                loadAllProducts();
            }
        }, 300);
        
        lastInputTime = Date.now();
    });
}

// Clear search results
function clearSearchResults() {
    var searchResults = document.getElementById('search-results');
    if (searchResults) {
        searchResults.innerHTML = '';
    }
}
</script>
@endsection
