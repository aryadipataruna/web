<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use Carbon\Carbon;

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

        return view('laporan.laporanStokGudang', compact(
            'tanggalCetak',
            'items'
        ));
    }
}