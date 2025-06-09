<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang; // Import the Barang model
use Carbon\Carbon; // For date manipulation

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

        // Assuming sales happened within this month, or we need to filter by tgl_laku
        // For simplicity, let's fetch items that were consigned or sold in January 2025
        // You might need more refined logic based on how "monthly report" is defined (e.g., items sold in that month)

        // For the example, we have specific items. Let's fetch them
        // Adjust this query to dynamically filter based on actual sales data for the month
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

        return view('laporan.laporanKomisi', compact(
            'bulan',
            'tahun',
            'tanggalCetak',
            'items',
            'totalHargaJual',
            'totalKomisiHunter',
            'totalKomisiReuseMart',
            'totalBonusPenitip'
        ));
    }
}