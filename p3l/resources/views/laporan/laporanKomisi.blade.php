<!DOCTYPE html>
<html>
<head>
    <title>Laporan Komisi Bulanan per Produk</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20mm; /* A4 standard margins */
            box-sizing: border-box;
            background-color: #fff;
        }
        .report-container {
            width: 100%;
            max-width: 190mm; /* A4 width - 2*10mm margin */
            border: 1px solid #000; /* Optional: border for a clean look */
            padding: 15mm;
            box-sizing: border-box;
            margin: 0 auto;
        }
        h1 {
            font-size: 1.5em;
            text-align: center;
            margin-bottom: 5px;
        }
        h2 {
            font-size: 1.2em;
            text-align: center;
            margin-top: 0;
            margin-bottom: 20px;
        }
        .header-info p {
            margin: 2px 0;
            font-size: 0.9em;
        }
        .item-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .item-table th, .item-table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
            font-size: 0.85em;
        }
        .item-table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        .total-row td {
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="report-container">
        <div style="text-align: center; margin-bottom: 20px;">
            <h2 style="margin: 0;">ReUse Mart</h2>
            <p style="margin: 0; font-size: 0.9em;">Jl. Green Eco Park No. 456 Yogyakarta</p>
        </div>

        <h2 style="text-align: center; margin-top: 0; margin-bottom: 20px;">LAPORAN KOMISI BULANAN</h2>

        <div class="header-info">
            <p>Bulan : {{ $bulan }}</p>
            <p>Tahun : {{ $tahun }}</p>
            <p>Tanggal cetak : {{ $tanggalCetak }}</p>
        </div>

        <table class="item-table">
            <thead>
                <tr>
                    <th>Kode Produk</th>
                    <th>Nama Produk</th>
                    <th class="text-right">Harga Jual</th>
                    <th>Tanggal Masuk</th>
                    <th>Tanggal Laku</th>
                    <th class="text-right">Komisi Hunter</th>
                    <th class="text-right">Komisi ReUse Mart</th>
                    <th class="text-right">Bonus Penitip</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item->id_barang }}</td>
                        <td>{{ $item->nama_barang }}</td>
                        <td class="text-right">Rp {{ number_format($item->harga_barang, 0, ',', '.') }}</td>
                        <td>{{ $item->tgl_titip->format('d/n/Y') }}</td>
                        <td>{{ $item->tgl_laku ? $item->tgl_laku->format('d/n/Y') : '-' }}</td>
                        <td class="text-right">Rp {{ number_format($item->komisi_hunter, 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($item->komisi_reuse_mart, 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($item->bonus_penitip, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="2">Total</td>
                    <td class="text-right">Rp {{ number_format($totalHargaJual, 0, ',', '.') }}</td>
                    <td colspan="2"></td>
                    <td class="text-right">Rp {{ number_format($totalKomisiHunter, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($totalKomisiReuseMart, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($totalBonusPenitip, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>