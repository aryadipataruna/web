<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Nota Pembelian - {{ $nomor_nota }}</title>
    <style>
        /* Pastikan menggunakan font yang mendukung karakter UTF-8, seperti DejaVu Sans */
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 10px; margin: 20px; color: #333; }
        .container { width: 100%; margin: auto; }
        .header-toko { text-align: center; margin-bottom: 20px; }
        .header-toko h1 { margin: 0; font-size: 20px; font-weight: bold; }
        .header-toko p { margin: 2px 0; font-size: 10px; }

        .info-section { margin-bottom: 15px; line-height: 1.5; }
        .info-section p { margin: 3px 0; }
        .info-label { display: inline-block; width: 100px; font-weight: normal; } /* Adjusted width */
        .info-value { display: inline-block; }

        .pembeli-detail p { margin: 2px 0; }
        .pembeli-detail .alamat { margin-left: 0; } /* No indent for alamat */

        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 10px; margin-top: 15px; }
        .items-table th, .items-table td { padding: 5px 4px; text-align: left; vertical-align: top; }
        .items-table th { border-bottom: 1px solid #555; font-weight: bold; }
        .items-table td { border-bottom: 1px dashed #999; }
        .items-table tr:last-child td { border-bottom: 1px solid #555; } /* Solid line for last item before total */
        .items-table .text-right { text-align: right; }

        .summary-container { overflow: auto; /* Clear floats */ margin-bottom: 10px;}
        .summary-table { width: 55%; float: right; border-collapse: collapse; } /* Aligned to right */
        .summary-table td { padding: 3px 4px; }
        .summary-table .text-right { text-align: right; }
        .summary-table .grand-total td { border-top: 1px solid #555; font-weight: bold; padding-top: 5px;}

        .poin-info { margin-top:15px; margin-bottom: 15px;}
        .poin-info p { margin: 3px 0; }

        .qc-info p { margin: 3px 0; }

        .footer-nota { margin-top: 25px; }
        .signature-area { margin-top: 30px; overflow: auto; }
        .signature-block { width: 48%; margin-top: 10px;}
        .diambil-oleh { float: left; }
        .hormat-kami { float: right; text-align: center;}
        .signature-line { margin-top: 45px; border-bottom: 1px solid #333; width: 190px; display: block; }
        .date-text { font-size: 10px; margin-top:5px;}
    </style>
</head>
<body>
    <div class="container">
        <div class="header-toko">
            <h1>ReUse Mart</h1>
            <p>Jl. Green Eco Park No. 456 Yogyakarta</p>
        </div>

        <div class="info-section">
            <p><span class="info-label">No Nota</span>: <span class="info-value">{{ $nomor_nota }}</span></p>
            <p><span class="info-label">Tanggal pesan</span>: <span class="info-value">{{ \Carbon\Carbon::parse($tanggalPesan)->format('d/m/Y H:i') }}</span></p>
            <p><span class="info-label">Lunas pada</span>: <span class="info-value">{{ $tanggalLunas ? \Carbon\Carbon::parse($tanggalLunas)->format('d/m/Y H:i') : '-' }}</span></p>
            <p><span class="info-label">Tanggal ambil</span>: <span class="info-value">{{ $tanggalAmbil ? \Carbon\Carbon::parse($tanggalAmbil)->format('d/m/Y') : '-' }}</span></p>
        </div>

        <div class="info-section pembeli-info">
            <div class="pembeli-detail">
                <p><span class="info-label">Pembeli</span>: <span class="info-value">{{ $pembeli->EMAIL_PEMBELI ?? $pembeli->email_pembeli }} / {{ $pembeli->NAMA_PEMBELI ?? $pembeli->nama_pembeli }}</span></p>
                <p class="alamat">{{ $alamatPengiriman }}</p> {{-- Alamat dari nota --}}
                <p><span class="info-label">Delivery</span>: <span class="info-value">{{ $metodePengiriman }}</span></p>
            </div>
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th class="text-right">Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                <tr>
                    <td>{{ $item->barang->nama_barang ?? 'Nama Barang Tidak Ada' }}</td>
                    {{-- Di nota contoh, harga per item adalah harga finalnya, bukan kuantitas * harga satuan.
                         Jika `total_harga` di `Penjualan` adalah harga jual item tersebut, gunakan itu.
                         Jika `harga_barang` di tabel `barang` adalah harga satuan, kalikan kuantitas.
                         Untuk nota contoh: `Kompor ... 2.000.000`. Kita anggap ini harga itemnya.
                    --}}
                    <td class="text-right">{{ number_format(($item->harga_satuan_saat_beli ?? $item->barang->harga_barang ?? 0), 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="summary-container">
            <table class="summary-table">
                <tr>
                    <td>Total</td>
                    <td class="text-right">{{ number_format($subtotalKeseluruhanBarang, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Ongkos Kirim</td>
                    <td class="text-right">{{ number_format($ongkosKirim, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td class="text-right">{{ number_format($subtotalKeseluruhanBarang + $ongkosKirim, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Potongan {{ $poinDigunakan ?? 0 }} poin</td>
                    <td class="text-right">- {{ number_format($nilaiPotonganPoin, 0, ',', '.') }}</td>
                </tr>
                <tr class="grand-total">
                    <td>Total</td>
                    <td class="text-right">{{ number_format($totalAkhirDibayar, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        <div class="info-section poin-info">
            <p>Poin dari pesanan ini: {{ $poinDiperoleh }}</p>
            <p>Total poin customer: {{ $totalPoinCustomer }}</p>
        </div>

        <div class="info-section qc-info">
            <p>QC oleh: {{ $qcOleh }}</p>
        </div>

        <div class="footer-nota">
            <div class="signature-area">
                <div class="signature-block diambil-oleh">
                    Diambil oleh:
                    <span class="signature-line"></span>
                    <span class="date-text">Tanggal: .........................</span>
                </div>
                <div class="signature-block hormat-kami">
                    Yogyakarta, {{ \Carbon\Carbon::now()->format('d F Y') }}
                    {{-- atau gunakan tanggal transaksi jika perlu --}}
                    <span class="signature-line"></span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
