@extends('layouts.side-navbar')

@section('content')

<div class="container-fluid px-4">

    {{-- SweetAlert for Success --}}
    @if ($message = Session::get('success'))
        <script>
            Swal.fire({
                title: "Success",
                icon: "success",
                text: "{{ $message }}",
                draggable: true
            });
        </script>
    @endif

    {{-- SweetAlert for Failed --}}
    @if ($message = Session::get('failed'))
        <script>
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "{{ $message }}"
            });
        </script>
    @endif

    <h1 class="mt-4">Welcome, {{ Auth::user()->username }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <div class="card">
        <div class="card-body">
            @if (Auth::user()->role === 'staff')
                <div class="card">
                    <div class="card-body">
                        <h3>Selamat Datang Petugas</h3>
                        <div class="card">
                            <div class="card-body text-center text-secondary d-flex flex-column">
                                <div class="bg-secondary bg-opacity-10 p-2 mb-2">
                                    <p class="mb-0">Total Penjualan Hari Ini</p>
                                </div>
                                <div class="bg-white p-3 mb-2 rounded shadow-sm">
                                    <h4 class="fw-normal">{{ $salesCountToday }}</h4>
                                    <p class="mb-0">Jumlah total penjualan yang terjadi hari ini.</p>
                                </div>
                                <div class="bg-secondary bg-opacity-10 p-2">
                                    Terakhir diperbarui: {{ $latestSale ? \Carbon\Carbon::parse($latestSale->created_at)->format('d M Y H:i') : 'Belum ada transaksi' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @elseif (Auth::user()->role === 'admin')
                <div class="row">
                    <div class="col-md-8">
                        <canvas id="salesChart"></canvas>
                    </div>
                    <div class="col-md-4">
                        <p class="text-secondary fw-bold text-center">Persentase Penjualan Produk</p>
                        <canvas id="productChart" style="height: 300px; width: 100%;"></canvas>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var dates = {!! json_encode($dates ?? []) !!};
            var salesCount = {!! json_encode($salesCountChart ?? []) !!};
            var productNames = {!! json_encode($productNames ?? []) !!};
            var productTotals = {!! json_encode($productTotals ?? []) !!};

            if (document.getElementById('salesChart')) {
                const ctxBar = document.getElementById('salesChart').getContext('2d');
                const salesChart = new Chart(ctxBar, {
                    type: 'bar',
                    data: {
                        labels: dates,
                        datasets: [{
                            label: 'Jumlah Penjualan',
                            data: salesCount,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: { beginAtZero: true }
                        }
                    }
                });
            }

            if (document.getElementById('productChart')) {
                const ctxPie = document.getElementById('productChart').getContext('2d');
                const productChart = new Chart(ctxPie, {
                    type: 'pie',
                    data: {
                        labels: productNames,
                        datasets: [{
                            data: productTotals,
                            backgroundColor: [
                                '#ff6384', '#36a2eb', '#ffce56',
                                '#4bc0c0', '#9966ff', '#ffa500'
                            ]
                        }]
                    },
                    options: {
                        responsive: true
                    }
                });
            }
        });
        </script>

</div>

@endsection
