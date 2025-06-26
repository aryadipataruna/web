<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use Carbon\Carbon;
use Spatie\Browsershot\Browsershot; // Make sure you've imported Browsershot

class LaporanStokGudangController extends Controller
{
    public function generateLaporanStok()
    {
        // Get the current date for the report
        $tanggalCetak = Carbon::now()->format('d F Y');

        // Fetch items that are currently in stock (status 'tersedia' and tgl_laku is NULL)
        // Eager load penitip and hunter relationships to avoid N+1 query problem
        $items = Barang::with(['penitip', 'hunter'])
                       ->where('status', 'tersedia')
                       ->whereNull('tgl_laku') // Only items not yet sold are in stock
                       ->get();

        // 1. Render the Blade view to HTML
        // You need to ensure the $html variable is defined here
        $html = view('laporan.laporanStokGudang', compact(
            'tanggalCetak',
            'items'
        ))->render(); // Use ->render() to get the HTML content as a string

        $fileName = 'Laporan_Stok_Gudang_' . Carbon::now()->format('Ymd_His') . '.pdf';
        $pdfPath = storage_path('app/public/' . $fileName); // Adjust path as needed

        // Generate PDF menggunakan Browsershot
        try {
            Browsershot::html($html)
                ->noSandbox()
                ->showBackground()
                ->format('A4')
                ->save($pdfPath);

            // Return PDF as a download response
            return response()->download($pdfPath, $fileName)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            \Log::error('PDF generation failed: ' . $e->getMessage());
            // Return a JSON response for errors
            return response()->json(['status' => false, 'message' => 'Gagal membuat PDF: ' . $e->getMessage()], 500);
        }
    }
}