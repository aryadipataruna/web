<?php
namespace App\Http\Controllers;

use App\Models\Donasi;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

// <-- 1. IMPORT PDF FACADE

class LaporanController extends Controller
{
    // Method untuk menampilkan HTML (tidak berubah)
    public function tampilkanDonasiBarang()
    {
        $dataDonasi   = Donasi::orderBy('tgl_donasi', 'desc')->get();
        $tahun        = date('Y');
        $tanggalCetak = Carbon::now()->translatedFormat('j F Y');

        return view('admin.laporan.laporan_donasiBarang', [
            'donasiData'   => $dataDonasi,
            'tahun'        => $tahun,
            'tanggalCetak' => $tanggalCetak,
        ]);
    }

    // METHOD BARU untuk download PDF
    public function downloadPDF()
    {
        // 2. Ambil data persis seperti method sebelumnya
        $dataDonasi   = Donasi::orderBy('tgl_donasi', 'desc')->get();
        $tahun        = date('Y');
        $tanggalCetak = Carbon::now()->translatedFormat('j F Y');

        // 3. Siapkan data untuk dikirim ke view
        $data = [
            'donasiData'   => $dataDonasi,
            'tahun'        => $tahun,
            'tanggalCetak' => $tanggalCetak,
        ];

        // 4. Load view dan data ke dalam PDF
        //    Gunakan view yang sama dengan yang ditampilkan di web
        $pdf = PDF::loadView('admin.laporan.laporan_donasiBarang', $data);

        // 5. Download PDF dengan nama file dinamis
        return $pdf->download('laporan-donasi-barang-' . date('Y-m-d') . '.pdf');
    }
}
