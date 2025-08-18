{{-- @extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="flex items-center pb-6 border-b-2 border-gray-200 mb-8">
            <a href="{{ route('products.index') }}" class="mr-4 p-2 text-gray-500 hover:text-gray-800 hover:bg-gray-100 rounded-full transition-colors duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Tambah Produk Baru</h1>
                <p class="text-gray-600 mt-1">Lengkapi detail produk di bawah ini.</p>
            </div>
        </div>

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/data-form" class="space-y-8">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-1 space-y-8">
                    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Produk</label>
                        <div class="aspect-square bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center overflow-hidden">
                            <div id="image-preview" class="hidden w-full h-full"><img id="preview-img" src="" alt="Preview" class="w-full h-full object-cover"></div>
                            <div id="upload-placeholder" class="text-center p-4">
                                <svg class="w-12 h-12 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <p class="text-sm text-gray-600 mt-2">Klik untuk upload</p>
                            </div>
                        </div>
                        <input type="file" name="image" id="image" accept="image/*" class="hidden" onchange="previewImage(this)">
                        <button type="button" onclick="document.getElementById('image').click()" class="mt-4 w-full px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200">Pilih Gambar</button>
                        @error('image')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-3">Informasi Utama</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Produk <span class="text-red-500">*</span></label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="barcode" class="block text-sm font-medium text-gray-700 mb-1">Barcode (SKU)</label>
                                <input type="text" name="barcode" id="barcode" value="{{ old('barcode') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                @error('barcode')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                                <select name="category_id" id="category_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                    <option value="">Pilih kategori</option>
                                    @foreach($categories as $category)<option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>@endforeach
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
                                <div class="relative"><span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span><input type="number" name="purchase_price" id="purchase_price" value="{{ old('purchase_price', 0) }}" class="pl-10 w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required></div>
                                @error('purchase_price')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="selling_price" class="block text-sm font-medium text-gray-700 mb-1">Harga Jual <span class="text-red-500">*</span></label>
                                <div class="relative"><span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span><input type="number" name="selling_price" id="selling_price" value="{{ old('selling_price', 0) }}" class="pl-10 w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required></div>
                                @error('selling_price')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stok Awal</label>
                                <input type="number" name="stock" id="stock" value="{{ old('stock', 0) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div>
                                <label for="minimum_stock" class="block text-sm font-medium text-gray-700 mb-1">Minimum Stok</label>
                                <input type="number" name="minimum_stock" id="minimum_stock" value="{{ old('minimum_stock', 5) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-4 pt-6 mt-8 border-t border-gray-200">
                <a href="{{ route('products.index') }}" class="px-6 py-2 text-gray-700 bg-white hover:bg-gray-100 border border-gray-300 rounded-lg font-medium transition-colors duration-200">Batal</a>
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition-colors duration-200 shadow-sm">Simpan Produk</button>
            </div>
        </form>
    </div>
</div>

<script>
// Script JS untuk preview gambar & modal barcode tidak perlu diubah, sudah cukup baik.
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
@endsection --}}

@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="flex items-center pb-6 border-b-2 border-gray-200 mb-8">
            <a href="{{ route('products.index') }}" class="mr-4 p-2 text-gray-500 hover:text-gray-800 hover:bg-gray-100 rounded-full transition-colors duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Tambah Produk Baru</h1>
                <p class="text-gray-600 mt-1">Lengkapi detail produk di bawah ini.</p>
            </div>
        </div>

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Kolom Kiri - Gambar Produk --}}
                <div class="lg:col-span-1 space-y-8">
                    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Produk</label>
                        <div class="aspect-square bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center overflow-hidden">
                            <div id="image-preview" class="hidden w-full h-full"><img id="preview-img" src="" alt="Preview" class="w-full h-full object-cover"></div>
                            <div id="upload-placeholder" class="text-center p-4">
                                <svg class="w-12 h-12 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <p class="text-sm text-gray-600 mt-2">Klik untuk upload</p>
                            </div>
                        </div>
                        <input type="file" name="image" id="image" accept="image/*" class="hidden" onchange="previewImage(this)">
                        <button type="button" onclick="document.getElementById('image').click()" class="mt-4 w-full px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200">Pilih Gambar</button>
                        @error('image')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Kolom Kanan - Detail Produk --}}
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-3">Informasi Utama</h3>

                        {{-- [GANTI BLOK GRID LAMA DENGAN BLOK FLEXBOX BARU INI] --}}
                        <div class="space-y-6">
                            {{-- Baris 1: Nama Produk --}}
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Produk <span class="text-red-500">*</span></label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            {{-- Baris 2: Barcode & Kategori --}}
                            <div class="flex flex-col md:flex-row md:space-x-6">
                                {{-- Kolom 1 (Barcode) --}}
                                <div class="flex-1">
                                    <label for="barcode" class="block text-sm font-medium text-gray-700 mb-1">Barcode (SKU)</label>
                                    <div class="flex">
                                        <input type="text" name="barcode" id="barcode" value="{{ old('barcode') }}" class="flex-grow border-gray-300 rounded-l-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 rounded-r-none">
                                        <button type="button" onclick="openScannerModal()" class="flex-shrink-0 inline-flex items-center px-4 py-2 bg-gray-100 border border-l-0 border-gray-300 rounded-r-lg hover:bg-gray-200 transition-colors duration-200">
                                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            <span class="ml-2 text-sm font-medium text-gray-700">Scan</span>
                                        </button>
                                    </div>
                                    @error('barcode')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                </div>
                                {{-- Kolom 2 (Kategori) --}}
                                <div class="flex-1 mt-6 md:mt-0">
                                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                                    <select name="category_id" id="category_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                        <option value="">Pilih kategori</option>
                                        @foreach($categories as $category)<option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>@endforeach
                                    </select>
                                    @error('category_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-3">Harga & Stok</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="purchase_price" class="block text-sm font-medium text-gray-700 mb-1">Harga Beli <span class="text-red-500">*</span></label>
                                <div class="relative"><span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span><input type="number" name="purchase_price" id="purchase_price" value="{{ old('purchase_price', 0) }}" class="pl-10 w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required></div>
                                @error('purchase_price')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="selling_price" class="block text-sm font-medium text-gray-700 mb-1">Harga Jual <span class="text-red-500">*</span></label>
                                <div class="relative"><span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span><input type="number" name="selling_price" id="selling_price" value="{{ old('selling_price', 0) }}" class="pl-10 w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required></div>
                                @error('selling_price')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stok Awal</label>
                                <input type="number" name="stock" id="stock" value="{{ old('stock', 0) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div>
                                <label for="minimum_stock" class="block text-sm font-medium text-gray-700 mb-1">Minimum Stok</label>
                                <input type="number" name="minimum_stock" id="minimum_stock" value="{{ old('minimum_stock', 5) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-4 pt-6 mt-8 border-t border-gray-200">
                <a href="{{ route('products.index') }}" class="px-6 py-2 text-gray-700 bg-white hover:bg-gray-100 border border-gray-300 rounded-lg font-medium transition-colors duration-200">Batal</a>
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition-colors duration-200 shadow-sm">Simpan Produk</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal HTML untuk Barcode Scanner --}}
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
@endsection

@push('scripts')
<script>
// Script JS untuk preview gambar
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

// Seluruh Logika JavaScript untuk Barcode Scanner
let codeReader = null;

function openScannerModal() {
    if (typeof ZXing === 'undefined') {
        alert('Library scanner belum siap, silakan coba lagi sesaat.');
        return;
    }

    if (!codeReader) {
        codeReader = new ZXing.BrowserMultiFormatReader();
    }

    document.getElementById('scanner-modal').classList.remove('hidden');

    codeReader.listVideoInputDevices()
        .then((videoInputDevices) => {
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

                    // Masukkan hasil scan ke input barcode
                    document.getElementById('barcode').value = result.text;

                    // Tutup scanner
                    closeScannerModal();
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

function closeScannerModal() {
    if (codeReader) {
        codeReader.reset();
    }
    document.getElementById('scanner-modal').classList.add('hidden');
}
</script>
@endpush
