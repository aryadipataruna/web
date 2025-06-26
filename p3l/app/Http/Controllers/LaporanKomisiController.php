<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang; // Import the Barang model
use Carbon\Carbon; // For date manipulation
use Spatie\Browsershot\Browsershot; // Import Browsershot

class LaporanKomisiController extends Controller
{
    public function generateLaporanKomisi()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // For display in the report header
        $bulan = Carbon::now()->translatedFormat('F'); // e.g., "Juni"
        $tahun = $currentYear;
        $tanggalCetak = Carbon::now()->format('d F Y');

        // Fetch items that were sold in the current month and year
        $items = Barang::whereNotNull('tgl_laku') // Ensure the item has been sold
                        ->whereMonth('tgl_laku', $currentMonth)
                        ->whereYear('tgl_laku', $currentYear)
                        ->get();

        // Calculate totals
        $totalHargaJual = 0;
        $totalKomisiHunter = 0;
        $totalKomisiReuseMart = 0;
        $totalBonusPenitip = 0;

        foreach ($items as $item) {
            $totalHargaJual += $item->harga_barang;
            $totalKomisiHunter += $item->komisi_hunter;
            $totalKomisiReuseMart += $item->komisi_reuse_mart;
            $totalBonusPenitip += $item->bonus_penitip;
        }

        // --- Render the Blade view to HTML first ---
        // This is crucial: we get the HTML content as a string
        $html = view('laporan.laporanKomisi', compact(
            'bulan',
            'tahun',
            'tanggalCetak',
            'items',
            'totalHargaJual',
            'totalKomisiHunter',
            'totalKomisiReuseMart',
            'totalBonusPenitip'
        ))->render(); // Use ->render() to get the HTML content

        // Define filename and path for the PDF
        $fileName = 'Laporan_Komisi_' . $bulan . '_' . $tahun . '_' . Carbon::now()->format('Ymd_His') . '.pdf';
        $pdfPath = storage_path('app/public/' . $fileName); // Adjust the path as needed

        // Generate PDF using Browsershot
        try {
            Browsershot::html($html)
                ->noSandbox() // Required for environments without a dedicated sandbox
                ->showBackground() // Ensures background colors/images are included
                ->format('A4') // Set paper format
                ->save($pdfPath); // Save the PDF to the specified path

            // Return PDF as a download response and delete the file after sending
            return response()->download($pdfPath, $fileName)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            // Log the error for debugging purposes
            \Log::error('PDF generation failed: ' . $e->getMessage());
            // Return a JSON response with an error message
            return response()->json(['status' => false, 'message' => 'Gagal membuat PDF: ' . $e->getMessage()], 500);
        }
    }
}