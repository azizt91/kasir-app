@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">📊 Laporan & Statistik</h1>
                <p class="text-gray-600 mt-1">Dashboard analisis dan laporan bisnis</p>
            </div>
            <div class="text-sm text-gray-500 bg-gray-100 px-3 py-2 rounded-lg">
                {{ now()->setTimezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB
            </div>
        </div>

        <div class="space-y-6">
            
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Today Sales -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6 bg-gradient-to-r from-blue-500 to-blue-600 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100 text-sm">Penjualan Hari Ini</p>
                                <p class="text-2xl font-bold">Rp {{ number_format($stats['today_sales'], 0, ',', '.') }}</p>
                                <p class="text-blue-100 text-xs">{{ $stats['today_transactions'] }} transaksi</p>
                            </div>
                            <div class="text-blue-200">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4zM18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Monthly Sales -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6 bg-gradient-to-r from-green-500 to-green-600 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-100 text-sm">Penjualan Bulan Ini</p>
                                <p class="text-2xl font-bold">Rp {{ number_format($stats['month_sales'], 0, ',', '.') }}</p>
                                <p class="text-green-100 text-xs">{{ $stats['month_transactions'] }} transaksi</p>
                            </div>
                            <div class="text-green-200">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products & Stock -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6 bg-gradient-to-r from-purple-500 to-purple-600 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-purple-100 text-sm">Total Produk</p>
                                <p class="text-2xl font-bold">{{ $stats['total_products'] }}</p>
                                <p class="text-purple-100 text-xs">{{ $stats['low_stock_products'] }} stok rendah</p>
                            </div>
                            <div class="text-purple-200">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 2L3 7v11a2 2 0 002 2h10a2 2 0 002-2V7l-7-5zM6 9a1 1 0 112 0v6a1 1 0 11-2 0V9zm6 0a1 1 0 10-2 0v6a1 1 0 102 0V9z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Categories & Users -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6 bg-gradient-to-r from-orange-500 to-orange-600 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-orange-100 text-sm">Kategori & User</p>
                                <p class="text-2xl font-bold">{{ $stats['total_categories'] }}</p>
                                <p class="text-orange-100 text-xs">{{ $stats['total_users'] }} pengguna</p>
                            </div>
                            <div class="text-orange-200">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Report Menu Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Sales Report -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-lg transition-shadow duration-200">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="bg-blue-100 p-3 rounded-lg mr-4">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Laporan Penjualan</h3>
                                <p class="text-sm text-gray-500">Transaksi dan pendapatan</p>
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">
                            Lihat detail transaksi penjualan berdasarkan periode tertentu dengan opsi download PDF/Excel.
                        </p>
                        <a href="{{ route('reports.sales') }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Buat Laporan
                        </a>
                    </div>
                </div>

                <!-- Product Report -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-lg transition-shadow duration-200">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="bg-green-100 p-3 rounded-lg mr-4">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Laporan Produk</h3>
                                <p class="text-sm text-gray-500">Data produk dan kategori</p>
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">
                            Daftar lengkap produk dengan harga, stok, dan nilai inventory berdasarkan kategori.
                        </p>
                        <a href="{{ route('reports.products') }}" 
                           class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Buat Laporan
                        </a>
                    </div>
                </div>

                <!-- Stock Report -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-lg transition-shadow duration-200">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="bg-purple-100 p-3 rounded-lg mr-4">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Laporan Stok</h3>
                                <p class="text-sm text-gray-500">Monitor inventory</p>
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">
                            Pantau stok produk, identifikasi stok rendah dan habis untuk restock planning.
                        </p>
                        <a href="{{ route('reports.stock') }}" 
                           class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Buat Laporan
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Overview -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Transactions -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Transaksi Terbaru</h3>
                        <div class="space-y-3">
                            @forelse($recentTransactions as $transaction)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $transaction->transaction_code }}</p>
                                        <p class="text-sm text-gray-500">{{ $transaction->user->name }} • {{ $transaction->created_at->format('d M Y H:i') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold text-green-600">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</p>
                                        <p class="text-xs text-gray-500">{{ $transaction->payment_method }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-center py-4">Belum ada transaksi</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Top Products -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Produk Terlaris Bulan Ini</h3>
                        <div class="space-y-3">
                            @forelse($topProducts as $product)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div class="flex-1">
                                        <p class="font-medium text-gray-900">{{ $product->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $product->category->name ?? 'Tanpa Kategori' }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold text-blue-600">{{ $product->total_sold }} terjual</p>
                                        <p class="text-xs text-gray-500">Rp {{ number_format($product->total_revenue, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-center py-4">Belum ada data penjualan</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Low Stock Alert -->
            @if($lowStockProducts->count() > 0)
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-red-700">Peringatan Stok Rendah</h3>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($lowStockProducts as $product)
                            <div class="flex items-center justify-between p-3 bg-red-50 border border-red-200 rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $product->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $product->category->name ?? 'Tanpa Kategori' }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-red-600">{{ $product->stock }}</p>
                                    <p class="text-xs text-gray-500">Min: {{ $product->minimum_stock }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection
