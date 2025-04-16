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
                    <h3>Produk yang dipilih</h3>
                    <div class="d-flex flex-column">
                            <div class="row align-items-center my-2">
                                <div class="col-8">
                                    <span class="text-secondary">kucing</span><br>
                                    <span class="text-secondary" style="font-size: 13px;">Rp. 200.000 x 2</span>
                                </div>
                                <h6 class="col text-secondary">Rp. 400.000</h6>
                            </div>
                            <input type="hidden" name="shop[]" value="id, nama, harga, jumlah, subTotal" hidden="">
                        
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="col-8">
                            <h5 class="mt-3 text-secondary">Total Keseluruhan : </h5>
                        </div>
                        <h5 class="mt-3 text-secondary">Rp 400.000</h5>
                        <input type="hidden" name="grandTotal" value="grandTotal">
                    </div>
                </div>
                <div class="ms-1 col">
                    <div class="mb-3">
                        <label for="member" class="form-label">
                            Member Status 
                            <small><span class="text-danger">Dapat juga membuat member</span></small>
                        </label>
                        <select id="member" name="member" class="form-select" onchange="toggleNoTelp()">
                            <option value="bukan member">Bukan Member</option>
                            <option value="member">Member</option>
                        </select>
                    </div>
                    
                    <div class="mb-3" id="noTelpContainer" style="display: none;">
                        <label for="noTelp" class="form-label">
                            No Telepon 
                            <small><span class="text-danger">(daftar/gunakan member)</span></small>
                        </label>
                        <input type="number" class="form-control" id="noTelp" name="noTelp">
                    </div>

                    <div class="mb-3">
                        <label for="totalBayar" class="form-label">Total Bayar</label>
                        <input type="text" class="form-control" id="totalBayar" name="totalBayar" oninput="formatRupiah(this)">
                        <!-- Input tersembunyi untuk menyimpan nilai angka bersih -->
                        <input type="hidden" id="totalBayarValue" name="totalBayarValue">
                        <span id="warningMessage" style="display: none;" class="text-danger">Jumlah bayar kurang</span>
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

<script>

    // buat munculin inputan no telp kalau user milih member
    function toggleNoTelp() {
        document.getElementById("noTelpContainer").style.display =
            document.getElementById("member").value === "member" ? "block" : "none";
    }

    // format rupiah buat di inputan harga
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
        document.getElementById("totalBayarValue").value = angka;  // Menyimpan nilai angka bersih
        console.log(document.getElementById('totalBayarValue').value);
    }

</script>

@endsection