@extends('layouts.side-navbar')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Penjualan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('sale.index') }}">Riwayat Transaksi</a></li>
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
                @foreach ($products as $item)   
                <div class="col">
                    <div class="card" style="max-width: 540px;">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['image'] }}" class="img-fluid rounded-start"/>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h4 class="card-title" id="nama-{{ $item['id'] }}">{{ $item['name_product'] ?? 'Produk tidak tersedia' }}</h4>
                                    <h5 class="card-text" id="harga-{{ $item['id'] }}">Rp {{ number_format($item['price'], 0, ',', '.') }}</h5>
                                    <p class="card-text">Stok: <span id="stok-{{ $item['id'] }}">{{ $item['stock'] }}</span></p>

                                    <button onclick="updateCount(-1, {{ $item['price'] }}, {{ $item['stock'] }}, 'count-{{ $item['id'] }}', 'subtotal-{{ $item['id'] }}', 'stok-{{ $item['id'] }}')" class="border-0 bg-transparent"> - </button>
                                    <span id="count-{{ $item['id'] }}">0</span>
                                    <button onclick="updateCount(1, {{ $item['price'] }}, {{ $item['stock'] }}, 'count-{{ $item['id'] }}', 'subtotal-{{ $item['id'] }}', 'stok-{{ $item['id'] }}')" class="border-0 bg-transparent"> + </button>

                                    <p class="card-text mt-3">Sub Total: Rp <span id="subtotal-{{ $item['id'] }}">0</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>        
        </div>
    </div>

    <script>
      function updateCount(amount, price, maxStock, countId, subtotalId, stokId) {
        const countElement = document.getElementById(countId);
        const subtotalElement = document.getElementById(subtotalId);
        const stokElement = document.getElementById(stokId);
        
        let count = parseInt(countElement.textContent);
        let stok = parseInt(stokElement.textContent);
        
        if (amount === 1 && stok <= 0){
          Swal.fire({
            icon: "error",
            title: "Stok Habis!",
            text: "Stok produk yang Anda pilih sudah habis!",
          });
          return;
        }

        count = Math.max(count + amount, 0);
        stok = Math.min(stok - amount, maxStock);

        if (count < 0) {
          count = 0;
          stok = maxStock;
        } else if (stok < 0) {
          stok = 0;
        }

        countElement.textContent = count;
        stokElement.textContent = stok;

        const subtotal = count * price;
        subtotalElement.textContent = new Intl.NumberFormat('id-ID').format(subtotal);
      };

      document.getElementById("checkoutButton").addEventListener("click", function () {
        let items = [];
        let barang = false;

        document.querySelectorAll("[id^='count-']").forEach(element => {
            let id = element.id.split('-')[1];
            let nama = document.getElementById(`nama-${id}`).textContent; // Ambil nama produk
            let jumlah = parseInt(element.textContent); 
            let harga = parseInt(document.getElementById(`harga-${id}`).textContent.replace(/\D/g, ''));

            if (jumlah > 0) {
                barang = true;
                items.push({ id, nama, jumlah, harga });
            }
        });

        if (!barang) {
            event.preventDefault(); 
            Swal.fire({
                icon: "warning",
                title: "Keranjang Kosong!",
                text: "Pilih barang terlebih dahulu sebelum melakukan transaksi.",
                confirmButtonColor: "#3085d6",
                confirmButtonText: "OK"
            });
            return;
        }

        let queryString = encodeURIComponent(JSON.stringify(items));
        window.location.href = `{{ route('sale.create') }}?cart=${queryString}`;
      });

    </script>
</div>        
@endsection          
