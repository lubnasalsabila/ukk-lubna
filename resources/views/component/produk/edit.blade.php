@extends('layouts.side-navbar')

@section('content')

<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Produk</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Produk</a></li>
        <li class="breadcrumb-item active">Edit Produk</li>
    </ol>
    <form action="{{ route('product.update', $product['id']) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="card">
            <div class="card-body row">
                <div class="ms-1 col">
                    <div class="mb-3">
                        <label for="name_product" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" id="name_product" name="name_product" value="{{ $product['name_product'] }}">
                    </div>
                    <div class="mb-3">
                        <label for="stock" class="form-label">Stok Produk</label>
                        <input type="number" class="form-control" id="stock" name="stock" value="{{ $product['stock'] }}"  disabled>
                    </div>
                </div>
                <div class="me-1 col">
                    <div class="mb-3">
                        <label for="price" class="form-label">Harga Produk</label>
                        <input type="text" class="form-control" id="price" name="price" oninput="formatRupiah(this)" value="Rp {{ number_format($product['price'], 0, ',', '.') }}">
                        <input type="hidden" id="hargaValue" name="hargaValue" value="{{ $product['price'] }}">
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Gambar Produk</label>
                        <input type="file" class="form-control" id="image" name="image" value="{{ $product['image'] }}">
                    </div>
                </div>
            </div>
            <div class="me-4 mb-4 d-flex ms-auto">
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
