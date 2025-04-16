@extends('layouts.side-navbar')

@section('content')

<div class="container-fluid px-4">
    <h1 class="mt-4">Riwayat Transaksi</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="home">Dashboard</a></li>
        <li class="breadcrumb-item active">Riwayat transaksi</li>
    </ol>
    <div class="d-flex">
        <a type="button" class="btn btn-info mb-3" href="">Export Penjualan (.xlsx)</a>
       
            <a href="" type="button" class="btn btn-secondary mb-3 ms-auto">
                Tambah Penjualan
            </a>
    </div>
    <div class="card mb-4">
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pelanggan</th>
                        <th>Tanggal Penjualan</th>
                        <th>Total Harga</th>
                        <th>Dibuat Oleh</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Nama Pelanggan</th>
                        <th>Tanggal Penjualan</th>
                        <th>Total Harga</th>
                        <th>Dibuat Oleh</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody >
                        <tr class="d-flex align-items-center">
                            <td>1</td>
                            <td>lubna</td>
                            <td>14 April 2025</td>
                            <td>Rp 500.000</td>
                            <td>kasir</td>
                            <td class="me-4 mb-4 d-flex ms-auto">
                                <button type="button" class="btn btn-warning me-1 btn-lihat"  data-bs-toggle="modal" data-bs-target="#show-id">
                                    Lihat
                                </button>
                                <a type="button" class="btn btn-primary ms-1" href="exportPDF">
                                    Unduh Bukti
                                </a>
                            </td>
                        </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>     
                                <!-- Modal -->
                            <div class="modal fade" id="show-id" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content p-2 rounded-0 shadow">
                                    <div class="modal-header border-0 pb-0">
                                    <h5 class="modal-title fw-semibold" id="exampleModalLabel">Detail Penjualan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                    </div>
                                    
                                    <hr>
                                    
                                    <div class="modal-body py-0">
                                    <!-- Info Member -->
                                    <div class="mb-3 small text-muted">
                                        <div class="d-flex justify-content-between">
                                        <div>
                                            <div>Member Status : Member</div>
                                            <div>No. HP: 09876541</div>
                                            <div>Poin Member:  250</div>
                                        </div>
                                        <div>
                                            <div>Bergabung Sejak: 14 Apr 2025</div>
                                        </div>
                                        </div>
                                    </div>
                                
                                    <!-- Tabel Produk -->
                                    <table class="table table-borderless mb-0">
                                        <thead class="text-muted">
                                        <tr>
                                            <th>Nama Produk</th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-end">Harga</th>
                                            <th class="text-end">Sub Total</th>
                                        </tr>
                                        </thead>
                                        <tbody class=" text-secondary">
                                                <tr>
                                                    <td> heels hitam </td>
                                                    <td class="text-center">2</td>
                                                    <td class="text-end">Rp 250.000 </td>
                                                    <td class="text-end">Rp 500.000</td>
                                                </tr>
                                        </tbody>
                                    </table>
                            
                                    <!-- Total -->
                                    <div class="d-flex justify-content-end mt-3 text-secondary small">
                                        <h6 class="fw-bold">Total: <span class="ms-5 me-2">Rp 500.000</span></h6>
                                    </div>
                            
                                    <!-- Footer Keterangan -->
                                    <div class="text-muted small mt-4 text-center">
                                        Dibuat pada : {{ now()->setTimezone('Asia/Jakarta') }} <br>
                                        Oleh : kasir
                                    </div>
                            
                                    </div>

                                    <hr>

                                    <div class="modal-footer border-0 pt-0">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                                </div>
                            </div>
                            


@endsection          
