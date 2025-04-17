@extends('layouts.side-navbar')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Transaksi</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('sale.index') }}">Riwayat Transaksi</a></li>
        <li class="breadcrumb-item"><a href="{{ route('DetailSale.index') }}">Penjualan</a></li>
        <li class="breadcrumb-item active">Transaksi</li>
    </ol>
    <form action="{{ route('sale.submit-next', $sale->id) }}" method="post">
        @csrf

        <div class="card">
            <div class="card-body d-flex p-4">
                <div class="me-5 col">
                    <div class="card border border-black border-2 p-3">
                        <table class="table table-borderless text-secondary">
                            <thead class="fw-normal">
                                <tr>
                                    <td scope="col">Nama Produk</td>
                                    <td scope="col">QTY</td>
                                    <td scope="col">Harga</td>
                                    <td scope="col">Sub Total</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sale->detail_sales as $item)
                                <tr>
                                    <td>{{ $item->products->name_product }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>Rp. {{ number_format($item->products->price, 0, ',', '.') }}</td>
                                    <td>Rp. {{ number_format($item->sub_total, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="text-end row">
                            <h5 class="fw-medium me-5 col">Total Harga</h5>
                            <h5  class="fw-medium col">Rp. {{ number_format($sale->total_price, 0, ',', '.') }}</h5>
                        </div>
                        <div class="text-end row">
                            <h5 class="fw-medium me-5 col">Total Bayar</h5>
                            <h5  class="fw-medium col">Rp. {{ number_format($sale->total_pay, 0, ',', '.') }}</h5>
                        </div>
                    </div>
                </div>
                <div class="ms-1 col">

                    <div class="mb-3">
                        <label for="customer_name" class="form-label">
                            Nama Member (identitas)
                        </label>
                        <input type="text" class="form-control" id="customer_name" name="customer_name" value="{{ $sale->customers->customer_name ?? '' }}">
                    </div>

                    <div class="mb-3">
                        <label for="poin" class="form-label">Poin</label>
                        <input type="text" class="form-control" id="poin" name="poin" value="{{ $sale->customers->poin }}" disabled>

                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                value="1"
                                id="checkDefault"
                                name="gunakan_poin"
                                {{ $isFirstPurchase ? 'disabled' : '' }}
                            >
                            <label class="form-check-label" for="checkDefault">
                                Gunakan Poin
                            </label>

                            @if ($isFirstPurchase)
                                <span class="text-danger">Poin tidak dapat digunakan untuk pembelian pertama.</span>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
            <div class="me-4 mb-4 d-flex ms-auto">
                <button type="submit" class="btn btn-primary ms-1" href="" id="submitButton">
                    <i class="fa-solid fa-paper-plane"></i>
                    Kirim
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
