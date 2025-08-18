<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Barcode Produk</title>
    <style>
        @page {
            margin: 1cm; /* Atur margin halaman cetak */
        }
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
        }
        .barcode-container {
            display: grid;
            grid-template-columns: repeat(5, 1fr); /* 5 kolom label per baris */
            gap: 10px;
        }
        .barcode-item {
            border: 1px solid #ccc;
            padding: 5px;
            text-align: center;
            overflow: hidden;
            page-break-inside: avoid; /* Mencegah label terpotong di antara halaman */
        }
        .product-name {
            font-size: 8px;
            font-weight: bold;
            margin-bottom: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .product-price {
            font-size: 7px;
            margin-bottom: 4px;
        }
        .barcode-svg {
            width: 100%;
            height: 40px;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="no-print" style="text-align: center; padding: 10px; background: #eee;">
    <p>Gunakan fungsi Print dari browser Anda (Ctrl+P) untuk mencetak.</p>
    <button onclick="window.print()">Cetak Halaman Ini</button>
</div>

<div class="barcode-container">
    @foreach($products as $product)
        @if($product->barcode)
            <div class="barcode-item">
                <div class="product-name" title="{{ $product->name }}">{{ $product->name }}</div>
                <div class="product-price">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</div>
                <div class="barcode-svg">
                    {{-- Generate Barcode SVG --}}
                    {!! DNS1D::getBarcodeSVG($product->barcode, 'C128', 1, 40, 'black', false) !!}
                </div>
            </div>
        @endif
    @endforeach
</div>

</body>
</html>
