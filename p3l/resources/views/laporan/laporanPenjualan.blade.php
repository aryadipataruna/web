<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan Bulanan {{ $tahun }}</title>
    <style>
        /* Styling dasar untuk dokumen cetak */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20mm; /* Margin standar A4 */
            box-sizing: border-box;
            background-color: #fff;
            font-size: 10pt;
        }
        .container {
            width: 100%;
            max-width: 190mm; /* Lebar A4 - 2*10mm margin */
            margin: 0 auto;
        }
        h1, h2, h3 {
            text-align: center;
            margin-bottom: 10px;
        }
        h1 { font-size: 1.8em; }
        h2 { font-size: 1.4em; }
        h3 { font-size: 1.1em; }
        .info-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .info-header p {
            margin: 2px 0;
        }
        /* Styling tabel laporan */
        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .report-table th, .report-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        .report-table th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .total-row {
            font-weight: bold;
            background-color: #e0e0e0;
        }
        /* Styling container grafik */
        .chart-container {
            width: 100%;
            height: 400px; /* Atur tinggi grafik */
            margin-top: 30px;
            page-break-before: always; /* Pastikan grafik mulai di halaman baru untuk pencetakan */
            position: relative; /* Penting untuk responsivitas Chart.js */
        }
    </style>
    <!-- Memuat Chart.js dari CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <!-- Header Laporan -->
        <div class="info-header">
            <h1>ReUse Mart</h1>
            <p>Jl. Green Eco Park No. 456 Yogyakarta</p>
        </div>

        <h2>LAPORAN PENJUALAN BULANAN</h2>
        <h3>Tahun : {{ $tahun }}</h3>
        <p class="info-header">Tanggal cetak: {{ \Carbon\Carbon::now()->format('d F Y H:i:s') }}</p>

        <!-- Tabel Laporan Penjualan -->
        <table class="report-table">
            <thead>
                <tr>
                    <th>Bulan</th>
                    <th>Jumlah Barang Terjual</th>
                    <th>Jumlah Penjualan Kotor</th>
                </tr>
            </thead>
            <tbody>
                {{-- Loop melalui data laporan bulanan yang dikirim dari controller --}}
                @foreach ($laporanBulananArray as $data)
                    <tr>
                        <td>{{ $data['bulan'] }}</td>
                        <td class="text-right">{{ number_format($data['jumlah_barang_terjual'], 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($data['jumlah_penjualan_kotor'], 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                {{-- Baris total keseluruhan --}}
                <tr class="total-row">
                    <td>Total</td>
                    <td class="text-right">{{ number_format($totalBarangTerjual, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($totalPenjualanKotor, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Container untuk Grafik Penjualan -->
        <div class="chart-container">
            <canvas id="penjualanChart"></canvas>
        </div>
    </div>

    <script>
        // Mendapatkan konteks canvas untuk Chart.js
        const ctx = document.getElementById('penjualanChart').getContext('2d');

        // Mendefinisikan array untuk label bulan dan data penjualan
        const labels = [];
        const dataPenjualan = [];

        // Mengisi array labels dan dataPenjualan dari data PHP yang disuntikkan oleh Blade
        @foreach ($laporanBulananArray as $data)
            labels.push("{{ $data['bulan'] }}");
            dataPenjualan.push({{ $data['jumlah_penjualan_kotor'] ?? 0 }}); // Menambahkan nullish coalescing untuk keamanan
        @endforeach

        // Membuat instance Chart.js
        const penjualanChart = new Chart(ctx, {
            type: 'bar', // Jenis grafik: Bar chart
            data: {
                labels: labels, // Label bulan
                datasets: [{
                    label: 'Jumlah Penjualan Kotor (Rp)', // Label dataset
                    data: dataPenjualan, // Data penjualan
                    backgroundColor: 'rgba(54, 162, 235, 0.8)', // Warna bar (biru muda)
                    borderColor: 'rgba(54, 162, 235, 1)', // Warna border bar
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true, // Membuat grafik responsif
                maintainAspectRatio: false, // Memungkinkan grafik tidak mempertahankan rasio aspeknya
                plugins: {
                    title: {
                        display: true,
                        text: 'Grafik Penjualan Bulanan (Total Penjualan Kotor)', // Judul grafik
                        font: {
                            size: 16
                        }
                    },
                    legend: {
                        display: false // Sembunyikan legend
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true, // Mulai sumbu Y dari nol
                        title: {
                            display: true,
                            text: 'Jumlah Penjualan Kotor (Rp)' // Judul sumbu Y
                        },
                        ticks: {
                            // Callback untuk memformat label sumbu Y sebagai mata uang Rupiah
                            callback: function(value, index, values) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Bulan' // Judul sumbu X
                        }
                    }
                }
            }
        });

        // Menambahkan event listener untuk merespons perubahan ukuran window
        // Ini memastikan grafik digambar ulang dan menyesuaikan jika kontainer berubah ukuran dinamis
        window.addEventListener('resize', () => {
            penjualanChart.resize();
        });
    </script>
</body>
</html>
