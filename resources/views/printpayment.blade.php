<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk KOSanKu</title>
    <style>
        @page {
            size: 58mm auto;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Arial', sans-serif;
            width: 58mm;
            margin: 0;
            padding: 2mm;
            font-size: 10px;
            color: #000;
        }

        .header {
            text-align: center;
            margin-bottom: 3mm;
        }

        .shop-name {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 1mm;
        }

        .shop-address {
            font-size: 9px;
            margin-bottom: 2mm;
        }

        .divider {
            border-top: 1px dashed #000;
            margin: 3mm 0;
        }

        .transaction-info {
            margin-bottom: 3mm;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1mm;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 3mm;
        }

        .items-table th {
            text-align: left;
            border-bottom: 1px dashed #000;
            padding-bottom: 1mm;
        }

        .items-table td {
            padding: 1mm 0;
        }

        .items-table .align-right {
            text-align: right;
        }

        .total-section {
            border-top: 1px dashed #000;
            padding-top: 2mm;
            margin-bottom: 3mm;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            font-size: 9px;
            margin-top: 5mm;
        }

        @media print {
            .no-print {
                display: none;
            }

            body {
                padding: 1mm;
            }
        }

        .print-btn {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 12px;
            margin: 10px 0;
            cursor: pointer;
            border-radius: 3px;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="shop-name">KOSanKu</div>
        <div class="shop-address">Telp: 0889-9103-4870</div>
    </div>

    <div class="divider"></div>

    <div class="transaction-info">
        <div class="info-row">
            <span>Tanggal:</span>
            <span>{{ date('d-m-Y H:i', strtotime($payment->created_at)) }}</span>
        </div>
        <div class="info-row">
            <span>Pelanggan:</span>
            <span>{{ $payment->user->name }}</span>
        </div>
        <div class="info-row">
            <span>Pesanan:</span>
            <span>{{ $payment->user->phone }}</span>
        </div>

        <div class="info-row">
            <span>email:</span>
            <span>{{ $payment->user->email }}</span>
        </div>
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th>Kamar</th>
                <th class="align-right">Capacity</th>
                <th class="align-right">Harga</th>
                <th class="align-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $payment->room->name }}</td>
                <td class="align-right">{{ $payment->room->capacity}} orang</td>
                <td class="align-right">{{ number_format($payment->amount, 0, ',', '.') }}</td>
                <td class="align-right">{{ number_format($payment->amount, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="total-section">
        <div class="total-row">
            <span>Total:</span>
            <span>{{ number_format($payment->amount, 0, ',', '.') }}</span>
        </div>
        <div class="total-row">
            <span>Grand Total:</span>
            <span>{{ number_format($payment->amount, 0, ',', '.') }}</span>
        </div>
    </div>

    <div class="divider"></div>

    <div class="footer">
        <div>Terima kasih atas kunjungan Anda</div>
        <div>** Semoga selamat sampai tujuan **</div>
        <div><b>www.kostanKu</b></div>
    </div>

    <script>
        // Fungsi untuk mencetak otomatis saat halaman dimuat
        window.onload = function() {
            // Untuk demo, kita tidak mencetak otomatis
            window.print();
        };

        // close window after print
        window.onafterprint = function() {
            // redirect ke halaman sebelumnya
            window.location.href = "{{ url()->previous() }}";
        }
    </script>
</body>

</html>