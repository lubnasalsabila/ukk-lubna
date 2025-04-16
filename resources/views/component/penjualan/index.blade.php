@extends('layouts.side-navbar')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Penjualan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="home">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="transaksi">Riwayat Transaksi</a></li>
        <li class="breadcrumb-item active">Penjualan</li>
    </ol>

    <div class="d-flex">
        <a type="button" id="checkoutButton" class="ms-auto btn btn-secondary mb-3">
            <i class="fa-solid fa-cart-shopping me-3"></i>
            Checkout
        </a> 
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row row-cols-1 row-cols-md-2 g-4">
                <div class="col">
                    <div class="card" style="max-width: 540px;">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="" class="img-fluid rounded-start"/>
                            </div>  
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h4 class="card-title" id="nama-i">kucing</h4>
                                    <h5 class="card-text" id="harga-i">Rp</h5>
                                    <p class="card-text">Stok: <span id="stok-i"></span></p>

                                    <button onclick="" class="border-0 bg-transparent"> - </button>
                                    <span id="count-i">0<span>          
                                    <button onclick="" class="border-0 bg-transparent"> + </button>

                                    <p class="card-text mt-3">Sub Total: Rp <span id="subtotal-i">0<span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>        
        </div>
    </div>

</div>        
@endsection          
