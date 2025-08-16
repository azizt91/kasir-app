<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductReportExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
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
            'Deskripsi',
            'Stok',
            'Stok Minimum',
            'Harga Beli',
            'Harga Jual',
            'Nilai Stok',
            'Status Stok',
            'Tanggal Dibuat'
        ];
    }

    public function map($product): array
    {
        $stockStatus = 'Normal';
        if ($product->stock <= 0) {
            $stockStatus = 'Habis';
        } elseif ($product->stock <= $product->minimum_stock) {
            $stockStatus = 'Rendah';
        }

        return [
            $product->name,
            $product->barcode,
            $product->category->name ?? 'Tanpa Kategori',
            $product->description,
            $product->stock,
            $product->minimum_stock,
            $product->purchase_price,
            $product->selling_price,
            $product->stock * $product->selling_price,
            $stockStatus,
            $product->created_at->format('d/m/Y')
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
        return 'Laporan Produk ' . date('d-m-Y');
    }
}
