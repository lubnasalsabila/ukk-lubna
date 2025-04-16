@extends('layouts.side-navbar')

@section('content')

<div class="container-fluid px-4">

    <h1 class="mt-4">Welcome, Good Morning</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <div class="card">
        <div class="card-body">
                <div class="card">
                    <div class="card-body">
                        <h3>Selamat Datang Petugas</h3>
                        <div class="card">
                            <div class="card-body text-center text-secondary d-flex flex-column">
                                <div class="bg-secondary bg-opacity-10 p-2 mb-2">
                                    <p class="mb-0">Total Penjualan Hari Ini</p>
                                </div>
                                <div class="bg-white p-3 mb-2 rounded shadow-sm">
                                    <h4 class="fw-normal">0</h4>
                                    <p class="mb-0">Jumlah total penjualan yang terjadi hari ini.</p>
                                </div>
                                <div class="bg-secondary bg-opacity-10 p-2">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <canvas id="salesChart"></canvas>
                    </div>
                    <div class="col-md-4">
                        <p class="text-secondary fw-bold text-center">Persentase Penjualan Produk</p>
                        <canvas id="productChart" style="height: 300px; width: 100%;"></canvas>
                    </div>
                </div>
        </div>
    </div>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Dummy Data
            const dates = [
                "14 April 2025",
                "15 April 2025",
                "16 April 2025",
                "17 April 2025",
                "18 April 2025",
                "19 April 2025",
                "20 April 2025"
            ];

            const salesCount = [12, 19, 3, 5, 2, 3, 7];

            const productNames = ['Pensil', 'Pulpen', 'Buku', 'Penghapus', 'Spidol'];
            const productTotals = [10, 15, 25, 5, 20];

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
                                '#4bc0c0', '#9966ff'
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
