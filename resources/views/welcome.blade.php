@php
use Illuminate\Support\Facades\Storage;
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - Sistem POS</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .gradient-bg {
            background-image: linear-gradient(to right, #4c51bf, #6b46c1);
        }
        .hero-image {
            /* background-image: url('https://placehold.co/1000x800/667EEA/FFFFFF?text=Modern+POS+System'); */
            background-image: url('/beautiful-family-standing-cash-counter.jpg');
            background-size: cover;
            background-position: center;
        }
        .text-shadow {
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body class="antialiased font-sans">
    <div class="bg-gray-50 min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white shadow-lg fixed top-0 left-0 w-full z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <div class="shrink-0 flex items-center">
                        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                            @if($storeSettings->store_logo && Storage::disk('public')->exists($storeSettings->store_logo))
                                <img src="{{ Storage::url($storeSettings->store_logo) }}"
                                     alt="{{ $storeSettings->store_name }}"
                                     class="w-10 h-10 rounded-lg object-cover">
                            @else
                                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h4a2 2 0 012 2v2a2 2 0 01-2 2H8a2 2 0 01-2-2v-2z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            @endif
                            <div class="hidden sm:block">
                                <h1 class="text-xl font-bold text-gray-800">{{ $storeSettings->store_name }}</h1>
                                <p class="text-xs text-gray-500">Point of Sale System</p>
                            </div>
                        </a>
                    </div>
                    <!-- <div class="flex-shrink-0">
                        <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                            <span class="text-3xl text-blue-600">🏪</span> MiniMarket POS
                        </h1>
                    </div> -->

                    <div class="flex items-center space-x-6">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-lg text-gray-600 hover:text-blue-600 transition-colors duration-300">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-lg text-gray-600 hover:text-blue-600 transition-colors duration-300">Login</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-blue-600 text-white px-5 py-2 rounded-lg font-semibold hover:bg-blue-700 transition-colors duration-300 transform hover:scale-105">Register</a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="relative pt-24 md:pt-32 pb-12 bg-white overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col lg:flex-row items-center justify-between">
                <div class="lg:w-1/2 text-center lg:text-left mb-10 lg:mb-0">
                    <h1 class="text-5xl md:text-6xl tracking-tight font-extrabold text-gray-900 leading-tight">
                        <span class="block text-blue-600">Sistem POS</span>
                        <span class="block">Modern & Efisien</span>
                    </h1>
                    <p class="mt-6 text-lg text-gray-500 max-w-xl mx-auto lg:mx-0">
                        Kelola toko Anda dengan mudah menggunakan sistem Point of Sale yang modern. Didesain dengan antarmuka yang intuitif dan fitur lengkap untuk manajemen produk, kategori, dan transaksi penjualan.
                    </p>
                    <div class="mt-8 flex flex-col sm:flex-row items-center justify-center lg:justify-start space-y-4 sm:space-y-0 sm:space-x-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="w-full sm:w-auto flex items-center justify-center px-8 py-4 border border-transparent text-base font-semibold rounded-lg text-white bg-blue-600 hover:bg-blue-700 md:text-lg transition-colors duration-300 transform hover:scale-105">
                                Masuk ke Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="w-full sm:w-auto flex items-center justify-center px-8 py-4 border border-transparent text-base font-semibold rounded-lg text-white bg-blue-600 hover:bg-blue-700 md:text-lg transition-colors duration-300 transform hover:scale-105">
                                Mulai Sekarang
                            </a>
                        @endauth
                        <a href="#features" class="w-full sm:w-auto flex items-center justify-center px-8 py-4 border-2 border-blue-600 text-base font-semibold rounded-lg text-blue-700 bg-white hover:bg-blue-50 md:text-lg transition-colors duration-300 transform hover:scale-105">
                            Pelajari Lebih Lanjut
                        </a>
                    </div>
                </div>

                <div class="lg:w-1/2 flex items-center justify-center">
                    <div class="hero-image h-96 w-full max-w-lg rounded-xl shadow-2xl transition-all duration-500 ease-in-out transform hover:scale-105"></div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div id="features" class="py-20 bg-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:text-center">
                    <h2 class="text-base text-blue-600 font-semibold tracking-wide uppercase">Fitur Lengkap</h2>
                    <p class="mt-2 text-4xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-5xl">
                        Semua yang Anda Butuhkan
                    </p>
                    <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                        Sistem POS yang dirancang khusus untuk kemudahan dan efisiensi pengelolaan toko Anda.
                    </p>
                </div>

                <div class="mt-16">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
                        <div class="flex flex-col items-center text-center p-6 bg-white rounded-xl shadow-lg transition-all duration-300 ease-in-out transform hover:scale-105 hover:shadow-xl">
                            <div class="flex items-center justify-center h-16 w-16 rounded-full gradient-bg text-white text-3xl mb-4">
                                📦
                            </div>
                            <p class="text-xl font-semibold text-gray-900">Manajemen Produk</p>
                            <p class="mt-2 text-base text-gray-500">
                                Kelola produk dengan mudah, termasuk barcode, kategori, harga, dan stok.
                            </p>
                        </div>
                        <div class="flex flex-col items-center text-center p-6 bg-white rounded-xl shadow-lg transition-all duration-300 ease-in-out transform hover:scale-105 hover:shadow-xl">
                            <div class="flex items-center justify-center h-16 w-16 rounded-full gradient-bg text-white text-3xl mb-4">
                                🛒
                            </div>
                            <p class="text-xl font-semibold text-gray-900">Transaksi Cepat</p>
                            <p class="mt-2 text-base text-gray-500">
                                Antarmuka kasir yang intuitif untuk transaksi penjualan yang cepat dan akurat.
                            </p>
                        </div>
                        <div class="flex flex-col items-center text-center p-6 bg-white rounded-xl shadow-lg transition-all duration-300 ease-in-out transform hover:scale-105 hover:shadow-xl">
                            <div class="flex items-center justify-center h-16 w-16 rounded-full gradient-bg text-white text-3xl mb-4">
                                📊
                            </div>
                            <p class="text-xl font-semibold text-gray-900">Laporan & Statistik</p>
                            <p class="mt-2 text-base text-gray-500">
                                Dashboard dengan statistik penjualan, produk terlaris, dan laporan lengkap.
                            </p>
                        </div>
                        <div class="flex flex-col items-center text-center p-6 bg-white rounded-xl shadow-lg transition-all duration-300 ease-in-out transform hover:scale-105 hover:shadow-xl">
                            <div class="flex items-center justify-center h-16 w-16 rounded-full gradient-bg text-white text-3xl mb-4">
                                ⚠️
                            </div>
                            <p class="text-xl font-semibold text-gray-900">Kontrol Stok</p>
                            <p class="mt-2 text-base text-gray-500">
                                Pantau stok produk secara real-time dengan notifikasi stok rendah.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-900 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <p class="text-gray-400 text-lg">
                    &copy; {{ date('Y') }} MiniMarket POS. Sistem Point of Sale untuk toko modern.
                </p>
            </div>
        </footer>
    </div>
</body>
</html>
