<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StockReportExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $products;
    protected $summary;

    public function __construct($products, $summary)
    {
        $this->products = $products;
        $this->summary = $summary;
    }

    public function collection()
    {
        return $this->products;
    }

    public function headings(): array
    {
        return [
            'Nama Produk',
            'Barcode',
            'Kategori',
            'Stok Saat Ini',
            'Stok Minimum',
            'Selisih',
            'Status Stok',
            'Harga Jual',
            'Nilai Stok',
            'Prioritas',
            'Tanggal Update'
        ];
    }

    public function map($product): array
    {
        $difference = $product->stock - $product->minimum_stock;
        $stockValue = $product->stock * $product->selling_price;
        
        $stockStatus = 'Normal';
        $priority = 'Normal';
        
        if ($product->stock <= 0) {
            $stockStatus = 'Habis';
            $priority = 'Urgent';
        } elseif ($product->stock <= $product->minimum_stock) {
            $stockStatus = 'Rendah';
            $priority = 'Tinggi';
        }

        return [
            $product->name,
            $product->barcode,
            $product->category->name ?? 'Tanpa Kategori',
            $product->stock,
            $product->minimum_stock,
            $difference,
            $stockStatus,
            $product->selling_price,
            $stockValue,
            $priority,
            $product->updated_at->format('d/m/Y H:i')
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function title(): string
    {
        return 'Laporan Stok ' . date('d-m-Y');
    }
}
