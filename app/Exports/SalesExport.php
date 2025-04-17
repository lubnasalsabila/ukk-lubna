<?php

namespace App\Exports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SalesExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Sale::with(['customers', 'detail_sales.products'])->latest()->get();
    }

    public function headings(): array
    {
        return [
            "Nama Pelanggan",
            "No HP Pelanggan",
            "Poin Pelanggan",
            "Produk",
            "Total Harga",
            "Total Bayar",
            "Total Diskon Poin",
            "Total Kembalian",
            "Tanggal Pembelian",
        ];
    }

    public function map($sale): array
    {
        $nama = $sale->customers->customer_name ?? 'Bukan Member';
        $noHp = $sale->customers->no_telp ?? '-';
        $poin = $sale->customers->poin ?? '';
        $produkList = $sale->detail_sales->map(function ($detail_Sale) {
            return "{$detail_Sale->products->name_product} ( {$detail_Sale->quantity} : Rp. " . number_format($detail_Sale->sub_total, 0, ',', '.') . ")";
        })->implode(", ");

        return [
            $nama,
            $noHp,
            $poin,
            $produkList,
            'Rp. ' . number_format($sale->total_price, 0, ',', '.'),
            'Rp. ' . number_format($sale->total_pay, 0, ',', '.'),
            // 'Rp. ' . number_format($sale->total_price - $sale->used_poin ?? 0, 0, ',', '.'),
            'Rp. ' . number_format($sale->used_poin ? ($sale->total_price) : 0, 0, ',', '.'),
            'Rp. ' . number_format($sale->cashback ?? 0, 0, ',', '.'),
            $sale->created_at->format('d-m-Y'),
        ];
    }
}
