<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Stok</title>
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
        .priority-urgent {
            background-color: #f8d7da;
            color: #721c24;
        }
        .priority-high {
            background-color: #fff3cd;
            color: #856404;
        }
        .priority-normal {
            background-color: #d4edda;
            color: #155724;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
        .row-urgent {
            background-color: #fff5f5;
        }
        .row-warning {
            background-color: #fffbf0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📦 LAPORAN STOK</h1>
        <p><strong>Minimarket POS System</strong></p>
        <p>Dicetak pada: {{ now()->format('d M Y, H:i') }} WIB</p>
    </div>

    <div class="summary">
        <h3 style="margin-top: 0; text-align: center;">RINGKASAN STOK</h3>
        <div class="summary-grid">
            <div class="summary-item">
                <div class="label">TOTAL PRODUK</div>
                <div class="value">{{ number_format($summary['total_products']) }}</div>
            </div>
            <div class="summary-item">
                <div class="label">STOK NORMAL</div>
                <div class="value">{{ number_format($summary['normal_stock_products']) }}</div>
            </div>
            <div class="summary-item">
                <div class="label">STOK RENDAH</div>
                <div class="value">{{ number_format($summary['low_stock_products']) }}</div>
            </div>
            <div class="summary-item">
                <div class="label">STOK HABIS</div>
                <div class="value">{{ number_format($summary['out_of_stock_products']) }}</div>
            </div>
        </div>
    </div>

    <h3>STATUS STOK PRODUK</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th class="text-center">Stok</th>
                <th class="text-center">Min</th>
                <th class="text-center">Selisih</th>
                <th class="text-center">Status</th>
                <th class="text-right">Nilai Stok</th>
                <th class="text-center">Prioritas</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $index => $product)
                @php
                    $difference = $product->stock - $product->minimum_stock;
                    $stockValue = $product->stock * $product->selling_price;
                    $priority = $product->stock <= 0 ? 'Urgent' : ($product->stock <= $product->minimum_stock ? 'Tinggi' : 'Normal');
                    $rowClass = $product->stock <= 0 ? 'row-urgent' : ($product->stock <= $product->minimum_stock ? 'row-warning' : '');
                @endphp
                <tr class="{{ $rowClass }}">
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name ?? 'Tanpa Kategori' }}</td>
                    <td class="text-center"><strong>{{ $product->stock }}</strong></td>
                    <td class="text-center">{{ $product->minimum_stock }}</td>
                    <td class="text-center">{{ $difference >= 0 ? '+' : '' }}{{ $difference }}</td>
                    <td class="text-center">
                        @if($product->stock <= 0)
                            <span class="status-badge status-out">Habis</span>
                        @elseif($product->stock <= $product->minimum_stock)
                            <span class="status-badge status-low">Rendah</span>
                        @else
                            <span class="status-badge status-normal">Normal</span>
                        @endif
                    </td>
                    <td class="text-right">Rp {{ number_format($stockValue, 0, ',', '.') }}</td>
                    <td class="text-center">
                        @if($priority === 'Urgent')
                            <span class="status-badge priority-urgent">{{ $priority }}</span>
                        @elseif($priority === 'Tinggi')
                            <span class="status-badge priority-high">{{ $priority }}</span>
                        @else
                            <span class="status-badge priority-normal">{{ $priority }}</span>
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

    @if($summary['out_of_stock_products'] > 0 || $summary['low_stock_products'] > 0)
    <div style="margin-top: 20px; padding: 15px; background-color: #fff3cd; border-left: 4px solid #ffc107;">
        <h4 style="margin-top: 0; color: #856404;">⚠️ PERINGATAN STOK</h4>
        <p style="margin: 5px 0; color: #856404;">
            <strong>{{ $summary['out_of_stock_products'] }}</strong> produk habis stok dan 
            <strong>{{ $summary['low_stock_products'] }}</strong> produk stok rendah memerlukan perhatian segera.
        </p>
        <p style="margin: 5px 0 0 0; color: #856404; font-size: 11px;">
            Silakan lakukan restock untuk produk-produk tersebut untuk menghindari kehilangan penjualan.
        </p>
    </div>
    @endif

    <div class="footer">
        <p>Laporan ini digenerate secara otomatis oleh sistem POS Minimarket</p>
        <p>© {{ date('Y') }} Minimarket POS System - All Rights Reserved</p>
    </div>
</body>
</html>
