@extends('layouts.side-navbar')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Detail Pembelian</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Detail Pembelian</li>
    </ol>
    <div class="bg-dark-subtle">
        <div class="card">
            <div class="card-body m-3">
                <div class=" mb-5">
                    <a type="button" class="btn btn-primary ms-1" href="{{ route('sale.exportPDF', $sale->id) }}">
                        <i class="fa-solid fa-arrow-down"></i>
                        Unduh
                    </a>
                    <a type="button" class="btn btn-secondary me-1" href="{{ route('sale.index') }}">
                        Kembali
                    </a>
                </div>
                <div class="d-flex justify-content-between">
                    @if ($sale->customers)
                        <div class="d-flex flex-column fw-light">
                            <h6 class="fw-bold">{{ $sale->customers->no_telp }}</h6>
                            <h6 class="text-secondary">
                                MEMBER SEJAK : {{ \Carbon\Carbon::parse($sale->customers->created_at)->translatedFormat('d F Y') }}
                            </h6>
                            <h6 class="text-secondary">
                                MEMBER POIN : {{ $sale->customers->poin }}
                            </h6>
                        </div>
                    @else
                        {{-- Buat div kosong agar struktur tetap seimbang --}}
                        <div></div>
                    @endif

                    {{-- div kanan tetap di ujung kanan --}}
                    <div class="d-flex flex-column me-5 text-end fw-light">
                        <h6 class="text-secondary">
                            Invoice - #{{ $sale->id }}
                        </h6>
                        <h6 class="text-secondary">
                            {{ \Carbon\Carbon::parse($sale->created_at)->translatedFormat('d F Y') }}
                        </h6>
                    </div>
                </div>

                <table class="table text-secondary">
                    <thead class="fw-normal">
                        <tr>
                            <th scope="col">Produk</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sale->detail_sales as $item)
                        <tr>
                            <td>{{ $item->products->name_product }}</td>
                            <td>Rp. {{ number_format($item->products->price, 0, ',', '.') }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>Rp. {{ number_format($item->sub_total, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="bg-secondary bg-opacity-10 row mt-5">
                    <div class="col-8 d-flex text-secondary">
                        <div class="flex-column m-3">
                            <h6 class="fw-light">POIN DIGUNAKAN</h6>
                            <h5>{{ $sale->used_poin }}</h5>
                        </div>
                        <div class="flex-column m-3">
                            <h6 class="fw-light">KASIR</h6>
                            <h5>{{ $sale->users->username }}</h5>
                        </div>
                        <div class="flex-column m-3 fw-light">
                            <h6 class="fw-light">KEMBALIAN</h6>
                            <h5>Rp. {{ number_format($sale->cashback, 0, ',', '.') }}</h5>
                        </div>
                    </div>
                    <div class="col-4 bg-black bg-opacity-75 p-2">
                        <h6 class="text-secondary fw-light">TOTAL</h6>
                        @if ( $sale->used_poin > 0 )
                            <h2 class="text-white text-end me-5 text-decoration-line-through">Rp. {{ number_format($sale->total_price + $sale->used_poin, 0, ',', '.') }}</h2>
                            <h2 class="text-white text-end me-5">Rp. {{ number_format($sale->total_price, 0, ',', '.') }}</h2>
                        @else
                            <h2 class="text-white text-end me-5">Rp. {{ number_format($sale->total_price, 0, ',', '.') }}</h2>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
