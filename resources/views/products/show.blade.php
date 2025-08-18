@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between pb-6 border-b-2 border-gray-200 mb-8">
            <div>
                <a href="{{ route('products.index') }}" class="flex items-center text-sm text-gray-500 hover:text-gray-800 mb-2">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    Kembali ke Daftar Produk
                </a>
                <h1 class="text-3xl font-bold text-gray-900">Detail Produk</h1>
            </div>
            <div class="mt-4 sm:mt-0">
                <a href="{{ route('products.edit', $product->id) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 shadow-sm transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Edit Produk
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-1 space-y-8">
                <div class="bg-white rounded-xl shadow-md border border-gray-200">
                    <div class="aspect-square">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/400' }}" alt="{{ $product->name }}" class="w-full h-full object-cover rounded-t-xl">
                    </div>
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gray-900">{{ $product->name }}</h2>
                        <p class="text-sm text-gray-500 mt-1">{{ $product->barcode }}</p>
                        <span class="mt-4 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">{{ $product->category->name ?? '-' }}</span>
                    </div>
                </div>
                 <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
                     <h3 class="text-lg font-semibold text-gray-900 mb-4">Harga & Stok</h3>
                      <dl class="space-y-4">
                        <div>
                            <dt class="text-sm text-gray-500">Harga Beli</dt>
                            <dd class="text-lg font-medium text-gray-800">Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">Harga Jual</dt>
                            <dd class="text-2xl font-bold text-green-600">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</dd>
                        </div>
                         <div>
                            <dt class="text-sm text-gray-500">Stok Saat Ini</dt>
                            <dd class="text-lg font-medium {{ $product->stock <= $product->minimum_stock ? 'text-red-600' : 'text-gray-800' }}">{{ $product->stock }} / min. {{ $product->minimum_stock }}</dd>
                        </div>
                    </dl>
                 </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-md border border-gray-200">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Riwayat Pergerakan Stok</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipe</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Catatan</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($product->stockMovements->sortByDesc('created_at') as $movement)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $movement->created_at->format('d M Y, H:i') }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $movement->type == 'in' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $movement->type == 'in' ? 'Masuk' : 'Keluar' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right text-sm font-medium">{{ ($movement->type == 'in' ? '+' : '-') . $movement->quantity }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $movement->notes }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="px-6 py-12 text-center text-gray-500">Tidak ada riwayat.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
