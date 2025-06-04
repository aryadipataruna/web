<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi Penitip</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 12px; /* Ukuran font dasar seperti di contoh */
        }
        .container {
            width: 100%;
            max-width: 800px; /* Batas lebar agar tidak terlalu lebar di layar besar */
            margin: auto;
        }
        .header-section, .report-details-section {
            margin-bottom: 15px;
        }
        .header-section h2 {
            margin: 0;
            font-size: 1.1em;
        }
        .header-section p {
            margin: 3px 0;
            font-size: 0.9em;
        }
        .report-details-section h3 {
            margin: 10px 0 5px 0;
            font-weight: bold;
            text-decoration: underline;
            font-size: 1em;
            text-align: center; /* Judul laporan di tengah */
        }
        .report-info p {
            margin: 2px 0;
            font-size: 0.9em;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid black;
            padding: 6px;
            text-align: left;
            font-size: 0.9em;
        }
        th {
            background-color: #f2f2f2; /* Warna header tabel */
            text-align: center;
        }
        td.numerical-data {
            text-align: right;
        }
        .total-row td {
            font-weight: bold;
        }
        .main-title {
            font-size: 1.1em; /* Sedikit lebih besar dari teks biasa */
            font-weight: bold;
            margin-bottom: 10px;
        }
        .report-info {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="main-title">
            8. Laporan untuk Penitip
        </div>

        <div class="header-section">
            <h2>ReUse Mart</h2>
            <p>Jl. Green Eco Park No. 456 Yogyakarta</p>
        </div>

        <div class="report-details-section">
            <h3>LAPORAN TRANSAKSI PENITIP</h3>
            <div class="report-info">
                <p>ID Penitip : PENT001</p>
                <p>Nama Penitip : John Doe</p>
                <p>Bulan : Februari</p>
                <p>Tahun : 2025</p>
                <p>Tanggal cetak: 10 Maret 2025</p>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Kode Produk</th>
                    <th>Nama Produk</th>
                    <th>Tanggal Masuk</th>
                    <th>Tanggal Laku</th>
                    <th>Harga Jual Bersih (sudah dipotong Komisi)</th>
                    <th>Bonus terjual cepat</th>
                    <th>Pendapatan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>K201</td>
                    <td>Kompor Tanam 3 tungku</td>
                    <td style="text-align: center;">5/1/2025</td> <td style="text-align: center;">7/1/2025</td> <td class="numerical-data">1.600.000</td>
                    <td class="numerical-data">30.000</td>
                    <td class="numerical-data">1.630.000</td>
                </tr>
                <tr>
                    <td>....</td>
                    <td>....</td>
                    <td style="text-align: center;">....</td>
                    <td style="text-align: center;">....</td>
                    <td class="numerical-data">....</td>
                    <td class="numerical-data">....</td>
                    <td class="numerical-data">....</td>
                </tr>
                <tr>
                    <td>....</td>
                    <td>....</td>
                    <td style="text-align: center;">....</td>
                    <td style="text-align: center;">....</td>
                    <td class="numerical-data">....</td>
                    <td class="numerical-data">....</td>
                    <td class="numerical-data">....</td>
                </tr>
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="4" style="text-align: center; font-weight: bold;">TOTAL</td>
                    <td class="numerical-data">1.600.000</td> <td class="numerical-data">30.000</td>   <td class="numerical-data">1.630.000</td> </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>
