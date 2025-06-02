<!DOCTYPE html>
<html>
<head>
    <title>Nota Penitipan Barang</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20mm; /* A4 standard margins */
            box-sizing: border-box;
            background-color: #fff;
        }
        .nota-container {
            width: 100%;
            max-width: 190mm; /* A4 width - 2*10mm margin */
            border: 1px solid #000;
            padding: 15mm;
            box-sizing: border-box;
            margin: 0 auto;
        }
        h1 {
            font-size: 1.5em;
            text-align: center;
            margin-bottom: 20px;
        }
        .header-info, .penitip-info, .item-details {
            margin-bottom: 10px;
        }
        .header-info div, .penitip-info div {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        .header-info span, .penitip-info strong {
            font-size: 0.9em;
        }
        .header-info p {
            margin: 0;
            font-size: 0.9em;
        }
        .item-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
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
        .total-section {
            text-align: right;
            margin-top: 15px;
            font-size: 0.9em;
        }
        .footer-signature {
            margin-top: 50px;
            text-align: center;
        }
        .footer-signature div {
            margin-top: 30px;
        }
        .bold { font-weight: bold; }
    </style>
</head>
<body>
    <div class="nota-container">
        <div style="text-align: center; margin-bottom: 20px;">
            <h2 style="margin: 0;">ReUse Mart</h2>
            <p style="margin: 0; font-size: 0.9em;">Jl. Green Eco Park No. 456 Yogyakarta</p>
        </div>

        <h3 style="text-align: center; margin-top: 0; margin-bottom: 20px; font-size: 1.2em;">Nota Penitipan Barang</h3>

        <div class="header-info">
            <div>
                <span>No Nota</span>
                <span>: {{ $penitipan->no_nota }}</span>
            </div>
            <div>
                <span>Tanggal penitipan</span>
                <span>: {{ $penitipan->tanggal_penitipan->format('d/n/Y H:i:s') }}</span>
            </div>
            <div>
                <span>Masa penitipan sampai</span>
                <span>: {{ $penitipan->masa_penitipan_sampai->format('d/n/Y') }}</span>
            </div>
        </div>

        <div class="penitip-info" style="margin-top: 20px;">
            <p><strong class="bold">Penitip : {{ $penitipan->id_penitip }} / {{ $penitipan->nama_penitip }}</strong></p>
            <p>{{ $penitipan->alamat_penitip }}</p>
            <p>Delivery: {{ $penitipan->delivery_kurir }}</p>
        </div>

        <div class="item-details" style="margin-top: 20px;">
            <table class="item-table">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Deskripsi</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Garansi</th>
                        {{-- <th>Berat (kg)</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @php $totalHarga = 0; @endphp
                    @foreach ($penitipan->barangs as $barang)
                        <tr>
                            <td>{{ $barang->nama_barang }}</td>
                            <td>{{ $barang->deskripsi_barang }}</td>
                            <td>{{ $barang->kategori }}</td>
                            <td>Rp {{ number_format($barang->harga_barang, 0, ',', '.') }}</td>
                            <td>{{ $barang->garansi}}</td>
                            {{-- <td>{{ $barang->berat_barang ?? 'N/A' }}</td> Add berat_barang to your schema/data if needed --}}
                        </tr>
                        @php $totalHarga += $barang->harga_barang; @endphp
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="total-section">
            <p><strong class="bold">Total Estimasi Harga Barang: Rp {{ number_format($totalHarga, 0, ',', '.') }}</strong></p>
        </div>

        <div class="footer-signature">
            <p>Diterima dan QC oleh:</p>
            <div style="margin-top: 60px;">
                <p>({{ $penitipan->qc_oleh }})</p>
            </div>
        </div>
    </div>
</body>
</html>