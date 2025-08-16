<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SalesReportExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $transactions;
    protected $summary;
    protected $startDate;
    protected $endDate;

    public function __construct($transactions, $summary, $startDate, $endDate)
    {
        $this->transactions = $transactions;
        $this->summary = $summary;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return $this->transactions;
    }

    public function headings(): array
    {
        return [
            'Kode Transaksi',
            'Tanggal',
            'Kasir',
            'Subtotal',
            'Diskon',
            'Pajak',
            'Total',
            'Metode Pembayaran',
            'Jumlah Bayar',
            'Kembalian',
            'Status'
        ];
    }

    public function map($transaction): array
    {
        return [
            $transaction->transaction_code,
            $transaction->created_at->format('d/m/Y H:i'),
            $transaction->user->name,
            $transaction->subtotal,
            $transaction->discount,
            $transaction->tax,
            $transaction->total_amount,
            ucfirst($transaction->payment_method),
            $transaction->amount_paid,
            $transaction->change_amount,
            ucfirst($transaction->status)
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
        return 'Laporan Penjualan ' . $this->startDate . ' - ' . $this->endDate;
    }
}
