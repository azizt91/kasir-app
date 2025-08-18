@php
use Illuminate\Support\Facades\Storage;
@endphp
@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="pb-6 border-b-2 border-gray-200 mb-8">
            <h1 class="text-3xl font-bold text-gray-900">⚙️ Pengaturan Toko</h1>
            <p class="text-gray-600 mt-1">Kelola informasi umum dan branding toko Anda.</p>
        </div>

        <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
            <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="p-6 sm:p-8 space-y-8">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-3 mb-6">Informasi Utama</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label for="store_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Toko <span class="text-red-500">*</span></label>
                                <input type="text" id="store_name" name="store_name" value="{{ old('store_name', $settings->store_name) }}" required
                                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                       placeholder="Contoh: Toko Barokah Jaya">
                                @error('store_name')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="store_phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                                <input type="text" id="store_phone" name="store_phone" value="{{ old('store_phone', $settings->store_phone) }}"
                                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                       placeholder="(021) 123-4567">
                                @error('store_phone')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="store_address" class="block text-sm font-medium text-gray-700 mb-1">Alamat Toko</label>
                                <textarea id="store_address" name="store_address" rows="3"
                                          class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 resize-none"
                                          placeholder="Jl. Pahlawan No. 123, Kota Bahagia">{{ old('store_address', $settings->store_address) }}</textarea>
                                @error('store_address')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="store_description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi/Footer Struk <span class="text-gray-500">(Opsional)</span></label>
                                <textarea id="store_description" name="store_description" rows="3"
                                          class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 resize-none"
                                          placeholder="Contoh: Terima kasih telah berbelanja! Barang yang sudah dibeli tidak dapat dikembalikan.">{{ old('store_description', $settings->store_description) }}</textarea>
                                @error('store_description')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-3 mb-6">Branding Toko</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                            <div class="md:col-span-1">
                                <p class="block text-sm font-medium text-gray-700 mb-2">Logo Saat Ini</p>
                                <div class="aspect-square w-32 h-32 bg-gray-100 rounded-lg border flex items-center justify-center">
                                    @if($settings->store_logo && Storage::disk('public')->exists($settings->store_logo))
                                        <img src="{{ Storage::url($settings->store_logo) }}" alt="Logo Toko" class="w-full h-full object-contain p-2 rounded-lg">
                                    @else
                                        <div class="text-center text-gray-500 text-xs p-2">
                                            <svg class="w-8 h-8 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            <p class="mt-1">Belum ada logo</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="md:col-span-2">
                                <label for="store_logo" class="block text-sm font-medium text-gray-700 mb-2">Upload Logo Baru <span class="text-gray-500">(Opsional)</span></label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="store_logo_input" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                <span>Upload file</span>
                                                <input id="store_logo_input" name="store_logo" type="file" class="sr-only">
                                            </label>
                                            <p class="pl-1">atau tarik dan lepas</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF hingga 2MB</p>
                                    </div>
                                </div>
                                @error('store_logo')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-6 sm:px-8 py-4 bg-gray-50 border-t border-gray-200 flex justify-end">
                    <button type="submit" class="w-full sm:w-auto flex items-center justify-center px-6 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 shadow-md transition-transform transform hover:scale-105 duration-300">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>

        @if(session('success'))
            <div id="success-toast" class="fixed bottom-5 right-5 flex items-center w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow-lg" role="alert">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                </div>
                <div class="ml-3 text-sm font-normal">{{ session('success') }}</div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8" onclick="document.getElementById('success-toast').style.display='none'">
                    <span class="sr-only">Close</span>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
            </div>
            <script>
                setTimeout(() => {
                    const toast = document.getElementById('success-toast');
                    if(toast) toast.style.display = 'none';
                }, 5000);
            </script>
        @endif

    </div>
</div>
@endsection



