@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-teal-600 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-sm">M</span>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-gray-900">Minimarket POS</h1>
                            <p class="text-xs text-gray-500">Point of Sale System</p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600">{{ auth()->user()->name ?? 'Admin' }}</span>
                    <div class="w-8 h-8 bg-gray-300 rounded-full"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Products Section -->
            <div class="lg:col-span-3">
                <!-- Search Bar -->
                <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
                    <div class="flex space-x-4">
                        <div class="flex-1">
                            <input type="text" id="product-search" placeholder="Cari produk atau scan barcode..." 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                        </div>
                        <button onclick="focusSearchInput()" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Scan
                        </button>
                    </div>
                    <div id="search-results" class="mt-4 space-y-2 max-h-60 overflow-y-auto"></div>
                </div>

                <!-- Category Tabs -->
                <div class="bg-white rounded-lg shadow-sm mb-6">
                    <div class="p-4 border-b">
                        <div id="category-tabs" class="flex space-x-1 overflow-x-auto">
                            <button onclick="filterByCategory('all')" class="category-tab active px-4 py-2 text-sm font-medium rounded-lg whitespace-nowrap text-white bg-teal-600 border-teal-600">
                                Semua
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div id="products-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                        <!-- Products will be loaded here -->
                    </div>
                    
                    <!-- Pagination -->
                    <div class="flex justify-between items-center mt-6 pt-4 border-t">
                        <span class="text-sm text-gray-500">Loading...</span>
                        <div class="flex space-x-1">
                            <!-- Pagination buttons will be loaded here -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cart Section -->
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
        <h3 class="text-lg font-semibold mb-4">Pembayaran</h3>
        
        <div class="space-y-4">
            <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Total Bayar</div>
                        <div class="text-lg font-bold text-blue-600" id="modal-total">Rp 0</div>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-sm text-gray-500">Kembalian</div>
                    <div class="text-lg font-bold text-orange-600" id="modal-change">Rp 0</div>
                </div>
            </div>
            
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
                <input type="number" id="amount-paid" placeholder="0" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                       oninput="updateModalPayment()">
                
                <div class="grid grid-cols-3 gap-2 mt-2">
                    <button type="button" onclick="setQuickAmount(50000)" class="px-3 py-2 text-sm bg-gray-100 rounded hover:bg-gray-200">50.000</button>
                    <button type="button" onclick="setQuickAmount(100000)" class="px-3 py-2 text-sm bg-gray-100 rounded hover:bg-gray-200">100.000</button>
                    <button type="button" onclick="setQuickAmount(150000)" class="px-3 py-2 text-sm bg-gray-100 rounded hover:bg-gray-200">150.000</button>
                    <button type="button" onclick="setQuickAmount(200000)" class="px-3 py-2 text-sm bg-gray-100 rounded hover:bg-gray-200">200.000</button>
                    <button type="button" onclick="setQuickAmount(500000)" class="px-3 py-2 text-sm bg-gray-100 rounded hover:bg-gray-200">500.000</button>
                    <button type="button" onclick="setQuickAmount(1000000)" class="px-3 py-2 text-sm bg-gray-100 rounded hover:bg-gray-200">1.000.000</button>
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
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Pembayaran Berhasil!</h3>
            <p class="text-gray-600 mb-6">Transaksi telah berhasil diproses</p>
            
            <div class="space-y-3 text-left mb-6">
                <div class="flex justify-between">
                    <span class="text-gray-600">No. Transaksi</span>
                    <span class="font-medium" id="transaction-id">TRX123456789</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Total Bayar</span>
                    <span class="font-medium" id="success-total">Rp 100.000</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Kembalian</span>
                    <span class="font-medium" id="success-change">Rp 0</span>
                </div>
            </div>
            
            <p class="text-sm text-gray-500 mb-4">Cetak Struk?</p>
            
            <div class="flex space-x-3">
                <button onclick="printReceipt()" 
                        class="flex-1 bg-green-500 text-white py-3 rounded-md hover:bg-green-600 font-medium flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Cetak Struk
                </button>
                <button onclick="closeSuccessModal()" 
                        class="flex-1 bg-red-500 text-white py-3 rounded-md hover:bg-red-600 font-medium">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Lewati
                </button>
            </div>
            
            <p class="text-xs text-gray-400 mt-3">Modal akan tertutup dalam 3 detik</p>
        </div>
    </div>
</div>
@endsection
