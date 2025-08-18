@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="flex items-center pb-6 border-b-2 border-gray-200 mb-8">
            <a href="{{ route('products.index') }}" class="mr-4 p-2 text-gray-500 hover:text-gray-800 hover:bg-gray-100 rounded-full transition-colors duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Edit Produk</h1>
                <p class="text-gray-600 mt-1">Memperbarui: <span class="font-semibold">{{ $product->name }}</span></p>
            </div>
        </div>

        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-1 space-y-8">
                    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Produk</label>
                        <div class="aspect-square bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center overflow-hidden">
                            <div id="image-preview" class="{{ $product->image ? '' : 'hidden' }} w-full h-full"><img id="preview-img" src="{{ $product->image ? asset('storage/' . $product->image) : '' }}" alt="Preview" class="w-full h-full object-cover"></div>
                            <div id="upload-placeholder" class="{{ $product->image ? 'hidden' : '' }} text-center p-4">
                                <svg class="w-12 h-12 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <p class="text-sm text-gray-600 mt-2">Klik untuk ganti</p>
                            </div>
                        </div>
                        <input type="file" name="image" id="image" accept="image/*" class="hidden" onchange="previewImage(this)">
                        <button type="button" onclick="document.getElementById('image').click()" class="mt-4 w-full px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200">Ganti Gambar</button>
                        @error('image')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-3">Informasi Utama</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Produk <span class="text-red-500">*</span></label>
                                <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="barcode" class="block text-sm font-medium text-gray-700 mb-1">Barcode (SKU)</label>
                                <input type="text" name="barcode" id="barcode" value="{{ old('barcode', $product->barcode) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                @error('barcode')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                                <select name="category_id" id="category_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                    <option value="">Pilih kategori</option>
                                    @foreach($categories as $category)<option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>@endforeach
                                </select>
                                @error('category_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-3">Harga & Stok</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="purchase_price" class="block text-sm font-medium text-gray-700 mb-1">Harga Beli <span class="text-red-500">*</span></label>
                                <div class="relative"><span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span><input type="number" name="purchase_price" id="purchase_price" value="{{ old('purchase_price', $product->purchase_price) }}" class="pl-10 w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required></div>
                                @error('purchase_price')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="selling_price" class="block text-sm font-medium text-gray-700 mb-1">Harga Jual <span class="text-red-500">*</span></label>
                                <div class="relative"><span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span><input type="number" name="selling_price" id="selling_price" value="{{ old('selling_price', $product->selling_price) }}" class="pl-10 w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required></div>
                                @error('selling_price')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stok Saat Ini</label>
                                <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div>
                                <label for="minimum_stock" class="block text-sm font-medium text-gray-700 mb-1">Minimum Stok</label>
                                <input type="number" name="minimum_stock" id="minimum_stock" value="{{ old('minimum_stock', $product->minimum_stock) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-4 pt-6 mt-8 border-t border-gray-200">
                <a href="{{ route('products.index') }}" class="px-6 py-2 text-gray-700 bg-white hover:bg-gray-100 border border-gray-300 rounded-lg font-medium transition-colors duration-200">Batal</a>
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition-colors duration-200 shadow-sm">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
// Script JS untuk preview gambar tidak perlu diubah.
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-img').src = e.target.result;
            document.getElementById('image-preview').classList.remove('hidden');
            document.getElementById('upload-placeholder').classList.add('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
