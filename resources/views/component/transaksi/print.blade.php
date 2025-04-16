@extends('layouts.side-navbar')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Detail Pembelian</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="">Dashboard</a></li>
        <li class="breadcrumb-item active">Detail Pembelian</li>
    </ol>
    <div class="bg-dark-subtle">
        <div class="card">
            <div class="card-body m-3">
                <div class=" mb-5">
                    <a type="button" class="btn btn-primary ms-1" href="">
                        <i class="fa-solid fa-arrow-down"></i>
                        Unduh
                    </a>
                    <a type="button" class="btn btn-secondary me-1" href="transaksi">
                        Kembali
                    </a>
                </div>
                <div class="d-flex justify-content-between">
                    {{-- div yang dibawah ini muncul hanya ketika menggunakan member --}}

                        <div class="d-flex flex-column fw-light">
                            <h6 class="fw-bold"></h6>
                            <h6 class="text-secondary">
                                MEMBER SEJAK : 
                            </h6>
                            <h6 class="text-secondary">
                                MEMBER POIN : 
                            </h6>
                        </div>
                    
                        {{-- Buat div kosong agar struktur tetap seimbang --}}
                        <div></div>
                    
                
                    {{-- div kanan tetap di ujung kanan --}}
                    <div class="d-flex flex-column me-5 text-end fw-light">
                        <h6 class="text-secondary">
                            Invoice - #
                        </h6>
                        <h6 class="text-secondary">
                            
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
                             
                        <tr>
                            <td>ayam</td>
                            <td>Rp. 25.000</td>
                            <td>3</td>
                            <td>Rp. 75.000</td>
                        </tr>
                     
                    </tbody>
                </table>
                
                <div class="bg-secondary bg-opacity-10 row mt-5">
                    <div class="col-8 d-flex text-secondary">
                        <div class="flex-column m-3">
                            <h6 class="fw-light">POIN DIGUNAKAN</h6>
                            <h5>0</h5>
                        </div>
                        <div class="flex-column m-3">
                            <h6 class="fw-light">KASIR</h6>
                            <h5>kasir</h5>
                        </div>
                        <div class="flex-column m-3 fw-light">
                            <h6 class="fw-light">KEMBALIAN</h6>
                            <h5>Rp. 25.000</h5>
                        </div>
                    </div>
                    <div class="col-4 bg-black bg-opacity-75 p-2">
                        <h6 class="text-secondary fw-light">TOTAL</h6>
                        
                            <h2 class="text-white text-end me-5 text-decoration-line-through">Rp. 75.000</h2>
                            <h2 class="text-white text-end me-5">Rp. 75.000</h2>
                        
                            <h2 class="text-white text-end me-5">Rp. 75.000</h2>
                        
                    </div>  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection