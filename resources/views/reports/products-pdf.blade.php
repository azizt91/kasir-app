<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Produk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .summary {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 30px;
        }
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }
        .summary-item {
            text-align: center;
        }
        .summary-item .label {
            font-weight: bold;
            color: #666;
            font-size: 11px;
        }
        .summary-item .value {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin-top: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
            font-size: 10px;
        }
        td {
            font-size: 9px;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .status-badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
        }
        .status-normal {
            background-color: #d4edda;
            color: #155724;
        }
        .status-low {
            background-color: #fff3cd;
            color: #856404;
        }
        .status-out {
            background-color: #f8d7da;
            color: #721c24;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📦 LAPORAN PRODUK</h1>
        <p><strong>Minimarket POS System</strong></p>
        <p>Dicetak pada: {{ now()->format('d M Y, H:i') }} WIB</p>
    </div>

    <div class="summary">
        <h3 style="margin-top: 0; text-align: center;">RINGKASAN PRODUK</h3>
        <div class="summary-grid">
            <div class="summary-item">
                <div class="label">TOTAL PRODUK</div>
                <div class="value">{{ number_format($summary['total_products']) }}</div>
            </div>
            <div class="summary-item">
                <div class="label">NILAI STOK (BELI)</div>
                <div class="value">Rp {{ number_format($summary['total_stock_value'], 0, ',', '.') }}</div>
            </div>
            <div class="summary-item">
                <div class="label">NILAI STOK (JUAL)</div>
                <div class="value">Rp {{ number_format($summary['total_selling_value'], 0, ',', '.') }}</div>
            </div>
            <div class="summary-item">
                <div class="label">STOK RENDAH</div>
                <div class="value">{{ number_format($summary['low_stock_count']) }}</div>
            </div>
        </div>
    </div>

    <h3>DAFTAR PRODUK</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Barcode</th>
                <th>Kategori</th>
                <th class="text-center">Stok</th>
                <th class="text-right">Harga Beli</th>
                <th class="text-right">Harga Jual</th>
                <th class="text-right">Nilai Stok</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $index => $product)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->barcode }}</td>
                    <td>{{ $product->category->name ?? 'Tanpa Kategori' }}</td>
                    <td class="text-center">{{ $product->stock }}</td>
                    <td class="text-right">Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($product->stock * $product->selling_price, 0, ',', '.') }}</td>
                    <td class="text-center">
                        @if($product->stock <= 0)
                            <span class="status-badge status-out">Habis</span>
                        @elseif($product->stock <= $product->minimum_stock)
                            <span class="status-badge status-low">Rendah</span>
                        @else
                            <span class="status-badge status-normal">Normal</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center" style="padding: 20px;">Tidak ada produk</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Laporan ini digenerate secara otomatis oleh sistem POS Minimarket</p>
        <p>© {{ date('Y') }} Minimarket POS System - All Rights Reserved</p>
    </div>
</body>
</html>
