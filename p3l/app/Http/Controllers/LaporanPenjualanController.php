<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang; // Import model Barang
use Carbon\Carbon; // Untuk manipulasi tanggal
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Storage;

class LaporanPenjualanController extends Controller
{
    public function generateLaporanPenjualanPdf(Request $request)
    {
        $tahun = $request->input('tahun', Carbon::now()->year); // Ambil tahun dari request, default tahun sekarang

        // Ambil data barang yang statusnya 'terjual' dan memiliki tgl_laku di tahun yang diminta
        $penjualanData = Barang::where('status', 'terjual')
            ->whereYear('tgl_laku', $tahun)
            ->get();

        // Inisialisasi array untuk menyimpan data bulanan
        $laporanBulanan = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthName = Carbon::create(null, $i, 1)->translatedFormat('F'); // Nama bulan
            $laporanBulanan[$i] = [
                'bulan' => $monthName,
                'jumlah_barang_terjual' => 0,
                'jumlah_penjualan_kotor' => 0,
            ];
        }

        // Agregasi data penjualan per bulan
        foreach ($penjualanData as $barang) {
            $bulan = Carbon::parse($barang->tgl_laku)->month;
            $laporanBulanan[$bulan]['jumlah_barang_terjual']++;
            $laporanBulanan[$bulan]['jumlah_penjualan_kotor'] += $barang->harga_barang;
        }

        // Total keseluruhan
        $totalBarangTerjual = array_sum(array_column($laporanBulanan, 'jumlah_barang_terjual'));
        $totalPenjualanKotor = array_sum(array_column($laporanBulanan, 'jumlah_penjualan_kotor'));

        // Ubah laporanBulanan menjadi array yang berindeks 0 agar mudah di-loop di view
        $laporanBulananArray = array_values($laporanBulanan);

        // Render view Blade ke HTML
        $html = view('laporan.laporanPenjualan', compact('laporanBulananArray', 'tahun', 'totalBarangTerjual', 'totalPenjualanKotor'))->render();

        // Tentukan path sementara untuk menyimpan PDF
        $fileName = 'laporan_penjualan_bulanan_' . $tahun . '.pdf';
        $pdfPath = storage_path('app/public/' . $fileName);

        // Generate PDF menggunakan Browsershot
        try {
            Browsershot::html($html)
                ->noSandbox()
                ->showBackground()
                ->format('A4')
                ->save($pdfPath);

            // Kembalikan PDF sebagai response download
            return response()->download($pdfPath, $fileName)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            \Log::error('PDF generation failed: ' . $e->getMessage());
            return response()->json(['status' => false, 'message' => 'Gagal membuat PDF: ' . $e->getMessage()], 500);
        }
    }
}