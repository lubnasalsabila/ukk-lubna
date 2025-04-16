@extends('layouts.side-navbar')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Transaksi</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="home">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="transaksi">Riwayat Transaksi</a></li>
        <li class="breadcrumb-item"><a href="penjualan">Penjualan</a></li>
        <li class="breadcrumb-item active">Transaksi</li>
    </ol>
    <form action="" method="post">
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
                                <tr>
                                    <td> heels hitam </td>
                                    <td> 2 </td>
                                    <td>Rp. 250.000</td>
                                    <td>Rp. 500.000</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="text-end row">
                            <h5 class="fw-medium me-5 col">Total Harga</h5>
                            <h5  class="fw-medium col">Rp. 500.000</h5>
                        </div>
                        <div class="text-end row">
                            <h5 class="fw-medium me-5 col">Total Bayar</h5>
                            <h5  class="fw-medium col">Rp. 500.000</h5>
                        </div>
                    </div>
                </div>
                <div class="ms-1 col">

                    <div class="mb-3">
                        <label for="namaMember" class="form-label">
                            Nama Member (identitas)
                        </label>
                        <input type="text" class="form-control" id="namaMember" name="namaMember" value="namaMember">
                    </div>

                    <div class="mb-3">
                        <label for="poin" class="form-label">Poin</label>
                        <input type="text" class="form-control" id="poin" name="poin" value="poin" disabled>
                        
                        <div class="form-check">
                            <input 
                                class="form-check-input" 
                                type="checkbox" 
                                value="1" 
                                id="checkDefault"
                                name="gunakan_poin"
                            >
                            <label class="form-check-label" for="checkDefault">
                                Gunakan Poin
                            </label>

                                <span class="text-danger">Poin tidak dapat digunakan untuk pembelian pertama.</span>

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