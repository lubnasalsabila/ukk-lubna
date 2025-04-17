@extends('layouts.side-navbar')

@section('content')

<div class="container-fluid px-4">
    <h1 class="mt-4">Transaksi</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('sale.index') }}">Riwayat Transaksi</a></li>
        <li class="breadcrumb-item"><a href="{{ route('DetailSale.index') }}">Penjualan</a></li>
        <li class="breadcrumb-item active">Transaksi</li>
    </ol>
    <form action="{{ route('sale.store') }}" method="post">
        @csrf

        <div class="card">
            <div class="card-body d-flex p-4">
                <div class="me-5 col">
                    <h3>Produk yang dipilih</h3>
                    <div class="d-flex flex-column">
                        @php
                            $grandTotal = 0;
                        @endphp
                        @foreach ($cart as $item)
                            @php
                                $subtotal = $item['harga'] * $item['jumlah'];
                                $grandTotal += $subtotal;
                            @endphp
                            <div class="row align-items-center my-2">
                                <div class="col-8">
                                    <span class="text-secondary">{{ $item['nama'] }}</span><br>
                                    <span class="text-secondary" style="font-size: 13px;">Rp. {{ number_format($item['harga'], 0, ',', '.') }} x {{ $item['jumlah'] }}</span>
                                </div>
                                <h6 class="col text-secondary">Rp. {{ number_format($subtotal, 0, ',', '.') }}</h6>
                            </div>
                            <input type="hidden" name="shop[]" value="{{ $item['id'] . ';' . $item['nama'] . ';' . $item['harga'] . ';' . $item['jumlah'] . ';' . $subtotal . ';'}}" hidden="">
                        @endforeach
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="col-8">
                            <h5 class="mt-3 text-secondary">Total Keseluruhan : </h5>
                        </div>
                        <h5 class="mt-3 text-secondary">Rp {{ number_format($grandTotal, 0, ',', '.') }}</h5>
                        <input type="hidden" name="grandTotal" value="{{ $grandTotal }}">
                    </div>
                </div>
                <div class="ms-1 col">
                    <div class="mb-3">
                        <label for="customer" class="form-label">
                            Member Status
                            <small><span class="text-danger">Dapat juga membuat member</span></small>
                        </label>
                        <select id="customer" name="customer" class="form-select" onchange="toggleNoTelp()">
                            <option value="bukan customer">Bukan Member</option>
                            <option value="customer">Member</option>
                        </select>
                    </div>

                    <div class="mb-3" id="no_telpContainer" style="display: none;">
                        <label for="no_telp" class="form-label">
                            No Telepon
                            <small><span class="text-danger">(daftar/gunakan member)</span></small>
                        </label>
                        <input type="text" class="form-control" id="no_telp" name="no_telp">
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
        document.getElementById("no_telpContainer").style.display =
            document.getElementById("customer").value === "customer" ? "block" : "none";
    }

    // format rupiah buat di inputan harga
    function formatRupiah(input) {
        let angka = input.value.replace(/\D/g, "");

        let formatted = new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR",
            minimumFractionDigits: 0
        }).format(angka);

        input.value = formatted;

        document.getElementById("totalBayarValue").value = angka;
        console.log(document.getElementById('totalBayarValue').value);
    }

    // buat warning message
    document.getElementById("totalBayar").addEventListener("input", function() {
        let totalBayar = parseInt(document.getElementById("totalBayarValue").value) || 0;
        let grandTotal = {{ $grandTotal }};
        let warningMessage = document.getElementById("warningMessage");
        let submitButton = document.getElementById("submitButton");

        if (totalBayar < grandTotal) {
            warningMessage.style.display = "block";
            submitButton.disabled = true;
            submitButton.classList.add("bg-opacity-50");
        } else {
            warningMessage.style.display = "none";
            submitButton.disabled = false;
        }
    });

</script>

@endsection
