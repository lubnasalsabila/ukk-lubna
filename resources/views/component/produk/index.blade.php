@extends('layouts.side-navbar')

@section('content')

<div class="container-fluid px-4">
    <h1 class="mt-4">Produk</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="home">Dashboard</a></li>
        <li class="breadcrumb-item active">Produk</li>
    </ol>
            <script>
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text:"error",
                    });
            </script>
            <script>
                Swal.fire({
                    title: "Success!",
                    icon: "success",
                    text:"success",
                    draggable: true
                });
            </script>
        

    <div class="d-flex">
            <a type="button" class="btn btn-secondary ms-auto mb-2" href="produk">
                <i class="fa-solid fa-plus"></i>
                Tambah Produk
            </a>
        
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
                        <tr class="d-flex align-items-center">
                            <td>1</td>
                            <td><img src="/img/kucing.jpeg" style="width: 70px; height: 70px;"></td>
                            <td>kucing</td>
                            <td>5</td>
                            <td>Rp 250.000</td>
                            <td class="me-2 mb-4 d-flex ms-auto">
                                    <a type="button" class="btn btn-warning" href="produk">
                                        Edit
                                    </a>
                                    <button type="button" class="btn btn-primary update-stok-btn"
                                        data-id=""
                                        data-name=""
                                        data-stok=""
                                        data-bs-toggle="modal" data-bs-target="#stokModal">
                                        Update stok
                                    </button>
                                    <button type="submit" class="btn btn-danger" onclick="">
                                        Delete
                                    </button>
                                    
                                    <!-- Form Hapus -->
                                    <form id="delete-form-id" action="" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                
                            </td>
                        </tr>
                    
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
                        <input type="number" class="form-control" id="modal-stok" name="stok">
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

@endsection
