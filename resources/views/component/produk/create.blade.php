@extends('layouts.side-navbar')

@section('content')

<div class="container-fluid px-4">
    <h1 class="mt-4">Tambah Produk</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="home">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="produk">Produk</a></li>
        <li class="breadcrumb-item active">Tambah Produk</li>
    </ol>
    <form action="" method="post" enctype="multipart/form-data">
            <script>
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text:"error"
                    });
            </script>
            <script>
                Swal.fire({
                    title: "Drag me!",
                    icon: "success",
                    text:"success",
                    draggable: true
                });
            </script>

        <div class="card">
            <div class="card-body row">
                <div class="ms-1 col">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="stok" class="form-label">Stok Produk</label>
                        <input type="number" class="form-control" id="stok" name="stok">
                    </div>
                </div>
                <div class="me-1 col">
                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga Produk</label>
                        <input type="text" class="form-control" id="harga" name="harga" oninput="formatRupiah(this)">
                        <!-- Input tersembunyi untuk menyimpan nilai angka bersih -->
                        <input type="hidden" id="hargaValue" name="hargaValue">
                    </div>
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Gambar Produk</label>
                        <input type="file" class="form-control" id="gambar" name="gambar">
                    </div>    
                </div>
            </div>
            <div class="me-4 mb-4 d-flex ms-auto">
                <a type="button" class="btn btn-secondary me-1" href="">
                    Reset
                </a>
                <button type="submit" class="btn btn-primary ms-1" href="">
                    <i class="fa-solid fa-paper-plane"></i>
                    Kirim Produk
                </button>
            </div>
        </div>
    </form>
</div>



<script>
function formatRupiah(input) {
    // Ambil nilai input dan hapus semua karakter selain angka
    let angka = input.value.replace(/\D/g, "");

    // Format angka ke Rupiah untuk tampilan (termasuk "Rp")
    let formatted = new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0
    }).format(angka);

    // Tampilkan kembali di input dengan "Rp"
    input.value = formatted;

    // Simpan nilai angka bersih dalam input tersembunyi sebelum form dikirim
    document.getElementById("hargaValue").value = angka;  // Menyimpan nilai angka bersih
    console.log(document.getElementById('hargaValue').value);
}
</script>

@endsection