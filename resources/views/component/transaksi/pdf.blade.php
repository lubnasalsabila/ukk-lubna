<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembelian</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    {{-- <link rel="stylesheet" href="./css/bootstrap.css"> --}}
    <style>
        .struk {
            max-width: 600px;
            margin: 50px auto;
            background-color: white;
            padding: 30px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            text-align: left;
            padding: 12px;
            border: none;
        }
        .table th {
            background-color: #f2f2f2;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 0.9em;
            color: #777;
        }
        .header-info {
            margin-bottom: 20px;
            border-bottom: 2px solid #dee2e6;
            padding-bottom: 10px;
        }
        .header-info p {
            margin-bottom: 5px;
        }
        .product-name {
            font-weight: bold;
        }
        .total-info p:nth-child(even) {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="struk">
        <h4 class="text-center mb-4">Indo April</h4>
        <div class="header-info">

                <p><strong>Member Status : </strong>Member</p>
                <p><strong>No. HP : </strong>0987621</p>
                <p><strong>Bergabung Sejak : </strong>14 Apr 2025</p>
                <p><strong>Poin Member : </strong>250</p>
                
                <p><strong>Member Status : </strong>Bukan Member</p>
                <p><strong>No. HP : </strong>-</p>
                <p><strong>Bergabung Sejak : </strong>-</p>
                <p><strong>Poin Member : </strong>-</p>

        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>Sub Total</th>
                </tr>
            </thead>
            <tbody>
                    <tr>
                        <td>Ayam</td>
                        <td>3</td>
                        <td>Rp 20.000</td>
                        <td>Rp 60.000</td>
                    </tr>
                <tr>
                    <th></th>
                    <th></th>
                    <th>Total Harga</th>
                    <th>Rp. 60.000</th>
                </tr>
                <tr>
                    <th>Poin Digunakan</th>
                    <th>0</th>
                    <th>Harga Setelah Poin</th>
                    <th>Rp. 60.000</th>
                </tr>
                <tr>
                    <th></th>
                    <th></th>
                    <th>Total Kembalian</th>
                    <th>Rp 40.000</th>
                </tr>
            </tbody>
        </table>
        <div class="footer"> 
            <p>14 Apr 2025 10:54:42 | kasir</p>
            <p>Terima kasih atas pembelian Anda!</p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>