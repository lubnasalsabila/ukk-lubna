@extends('layouts.side-navbar')

@section('content')

<div class="container-fluid px-4">
    <h1 class="mt-4">Produk</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Produk</li>
    </ol>

        @if ($message = Session::get('failed')) 
            <script>
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text:"{{ $message }}",
                    });
            </script>
        @endif
        @if ($message = Session::get('success')) 
            <script>
                Swal.fire({
                    title: "Success!",
                    icon: "success",
                    text:"{{ $message }}",
                    draggable: true
                });
            </script>
        @endif

    <div class="d-flex">
        @if (Auth::user() && Auth::user()->role !== 'staff' )
            <a type="button" class="btn btn-secondary ms-auto mb-2" href="{{ route('product.create') }}">
                <i class="fa-solid fa-plus"></i>
                Tambah Produk
            </a>
        @endif
    </div>
    <div class="card mb-4">
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Nama Produk</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Gambar</th>
                        <th>Nama Produk</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody >
                    @php $no = 1; @endphp
                    @foreach ($products as $item)
                        <tr class="d-flex align-items-center">
                            <td>{{ $no++ }}</td>
                            <td><img src="{{ asset('storage/' . $item['image']) }}" alt={{ $item['image'] }} style="width: 70px; height: 70px;"></td>
                            <td>{{ $item['name_product'] }}</td>
                            <td>{{ $item['stock'] }}</td>
                            <td>Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                            <td class="me-2 mb-4 d-flex ms-auto">
                                @if (Auth::user() && Auth::user()->role == 'staff')
                                    - 
                                @else
                                    <a type="button" class="btn btn-warning" href="{{ route('product.edit', $item['id']) }}">
                                        Edit
                                    </a>
                                    <button type="button" class="btn btn-primary update-stok-btn"
                                        data-id="{{ $item['id'] }}"
                                        data-name="{{ $item['name_product'] }}"
                                        data-stok="{{ $item['stock'] }}"
                                        data-bs-toggle="modal" data-bs-target="#stokModal">
                                        Update stok
                                    </button>
                                    <button type="submit" class="btn btn-danger" onclick="confirmDelete({{ $item['id'] }})">
                                        Delete
                                    </button>
                                    
                                    <!-- Form Hapus -->
                                    <form id="delete-form-{{ $item['id'] }}" action="{{ route('product.delete', $item['id']) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>    

<!-- Modal -->
<div class="modal fade" id="stokModal" tabindex="-1" aria-labelledby="stokModalLabel" aria-hidden="true">
    <form id="stokForm" method="post" >
        @csrf
        @method('PATCH')
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="stokModalLabel">Update Stok</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="modal-name" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" id="modal-name" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="modal-stok" class="form-label">Stok Produk</label>
                        <input type="number" class="form-control" id="modal-stok" name="stock">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update Stok</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const modalName = document.getElementById('modal-name');
        const modalStok = document.getElementById('modal-stok');
        const stokForm = document.getElementById('stokForm');

        // Gunakan event delegation untuk menangani klik tombol update stok
        document.addEventListener("click", function(event) {
            // Cek apakah tombol yang diklik memiliki class .update-stok-btn
            if (event.target.classList.contains("update-stok-btn")) {
                // Ambil data yang dibutuhkan dari tombol yang diklik
                const button = event.target;
                const id = button.dataset.id;
                const name = button.dataset.name;
                const stok = button.dataset.stok;

                // Debugging data
                console.log(`Tombol update stok ditekan`);
                console.log("ID Produk:", id);
                console.log("Nama Produk:", name);
                console.log("Stok Produk:", stok);

                // Isi modal dengan data produk
                modalName.value = name || ''; 
                modalStok.value = stok || 0;

                // Update action form agar sesuai dengan produk yang dipilih
                stokForm.action = `/product/updateStok/${id}`;

                // Debugging setelah modal terisi
                console.log(`Mengisi modal dengan data: ID=${id}, Nama=${name}, Stok=${stok}`);
            }
        });
    });

   // JavaScript untuk konfirmasi delete 
    function confirmDelete(userId) {
        Swal.fire({
            title: "Apakah Anda yakin?",
            text: "Data produk akan dihapus secara permanen!",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, hapus!"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${userId}`).submit();
            }
        });
    }
</script>

@endsection
