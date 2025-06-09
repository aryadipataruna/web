<!DOCTYPE html>
<html>
<head>
    <title>Laporan Stok Gudang</title>
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
        .text-right {
            text-align: right;
        }
        .note-box {
            border: 1px solid #000;
            padding: 10px;
            margin-top: 15px;
            font-size: 0.85em;
            float: right; /* Position it to the right as in the image */
            width: 30%; /* Adjust width as needed */
            box-sizing: border-box;
        }
        .clear-float {
            clear: both;
        }
    </style>
</head>
<body>
    <div class="report-container">
        <div style="text-align: center; margin-bottom: 20px;">
            <h2 style="margin: 0;">ReUse Mart</h2>
            <p style="margin: 0; font-size: 0.9em;">Jl. Green Eco Park No. 456 Yogyakarta</p>
        </div>

        <h2 style="text-align: left; margin-top: 0; margin-bottom: 5px;">LAPORAN Stok Gudang</h2>
        <div class="header-info">
            <p>Tanggal cetak: {{ $tanggalCetak }}</p>
        </div>

        <div class="clear-float"></div> <table class="item-table">
            <thead>
                <tr>
                    <th>Kode Produk</th>
                    <th>Nama Produk</th>
                    <th>ID Penitip</th>
                    <th>Nama Penitip</th>
                    <th>Tanggal Masuk</th>
                    <th>Perpanjangan</th>
                    <th>ID Hunter</th>
                    <th>Nama Hunter</th>
                    <th class="text-right">Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item->id_barang }}</td>
                        <td>{{ $item->nama_barang }}</td>
                        <td>{{ $item->id_penitip }}</td>
                        <td>{{ $item->penitip->NAMA_PENITIP ?? '-' }}</td> {{-- Use optional chaining for relationships --}}
                        <td>{{ $item->tgl_titip->format('d/n/Y') }}</td>
                        <td>{{ $item->getStatusPerpanjanganAttribute() }}</td> {{-- Use the accessor --}}
                        <td>{{ $item->id_pegawai ?? '-' }}</td>
                        <td>{{ $item->pegawai->NAMA_PEGAWAI ?? '-' }}</td> {{-- Use optional chaining for relationships --}}
                        <td class="text-right">Rp {{ number_format($item->harga_barang, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>