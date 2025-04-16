@extends('layouts.side-navbar')

@section('content')

<div class="container-fluid px-4">
    <h1 class="mt-4">Riwayat Transaksi</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Riwayat transaksi</li>
    </ol>
    <div class="d-flex">
        <a type="button" class="btn btn-info mb-3" href="">Export Penjualan (.xlsx)</a>
        @if (Auth::user() && Auth::user()->role !== 'admin' )
            <a href="{{ route('DetailSale.index') }}" type="button" class="btn btn-secondary mb-3 ms-auto">
                Tambah Penjualan
            </a>
        @endif
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
                    @php $no = 1; @endphp
                    @foreach ($sales as $item)
                        <tr class="d-flex align-items-center">
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->customer->customer_name ?? 'NON-MEMBER' }}</td>
                            <td>{{ $item->created_at->format('Y-m-d') }}</td>
                            <td>Rp {{ number_format($item['total_price'], 0, ',', '.') }}</td>
                            <td>{{ $item->user->username}}</td>
                            <td class="me-4 mb-4 d-flex ms-auto">
                                <button type="button" class="btn btn-warning me-1 btn-lihat"  data-bs-toggle="modal" data-bs-target="#show-{{ $item->id }}">
                                    Lihat
                                </button>
                                <a type="button" class="btn btn-primary ms-1" href="{{ route('transaksi.exportPDF', $item->id) }}">
                                    Unduh Bukti
                                </a>
                            </td>
                        </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>     
                            @foreach ($sales as $lihat)
                                <!-- Modal -->
                            <div class="modal fade" id="show-{{ $lihat->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                            <div>Member Status :{{ $lihat->customer ? 'Member' : 'Bukan Member' }}</div>
                                            <div>No. HP: {{ $lihat->customer ? $lihat->customer->no_telp : '-' }}</div>
                                            <div>Poin Member:  {{ $lihat->customer ? $lihat->customer->poin : 0 }}</div>
                                        </div>
                                        <div>
                                            <div>Bergabung Sejak: {{ $lihat->customer ? $lihat->customer->created_at->format('d F Y') : '-' }}</div>
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
                                        @foreach ($detail_sales as $jual)
                                            @if ($lihat->id == $jual->sale_id)
                                                <tr>
                                                    <td> {{ $jual->product ? $jual->product->name_product : '-' }} </td>
                                                    <td class="text-center">{{ $jual->quantity }}</td>
                                                    <td class="text-end"> {{ 'Rp. ' . number_format($jual->produk['price'], 0, ',', '.') }} </td>
                                                    <td class="text-end">{{ 'Rp. ' . number_format($jual['sub_total'], 0, ',', '.') }} </td>
                                                    @endif
                                                </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                            
                                    <!-- Total -->
                                    <div class="d-flex justify-content-end mt-3 text-secondary small">
                                        <h6 class="fw-bold">Total: <span class="ms-5 me-2">{{ 'Rp. ' . number_format($lihat['total_price'], 0, ',', '.') }} </span></h6>
                                    </div>
                            
                                    <!-- Footer Keterangan -->
                                    <div class="text-muted small mt-4 text-center">
                                        Dibuat pada : {{ now()->setTimezone('Asia/Jakarta') }}                                    <br>
                                        Oleh : {{ $lihat->user->username }}
                                    </div>
                            
                                    </div>

                                    <hr>

                                    <div class="modal-footer border-0 pt-0">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                                </div>
                            </div>
                            @endforeach


@endsection          
