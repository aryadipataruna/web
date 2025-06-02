<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenitipanBarang; // Import model PenitipanBarang
use Spatie\Browsershot\Browsershot; // Import Browsershot
use Illuminate\Support\Facades\Storage; // Untuk menyimpan file sementara

class PenitipanController extends Controller
{
    public function generateNotaPdf($noNota)
    {
        // 1. Ambil data penitipan barang beserta barang-barangnya
        $penitipan = PenitipanBarang::with('barangs')->find($noNota);

        if (!$penitipan) {
            abort(404, 'Nota penitipan tidak ditemukan.');
        }

        // 2. Render view Blade ke HTML
        $html = view('pdf.nota_penitipan', compact('penitipan'))->render();

        // 3. Tentukan path sementara untuk menyimpan PDF
        $fileName = 'nota_penitipan_' . $noNota . '.pdf';
        $pdfPath = storage_path('app/public/' . $fileName);

        // 4. Generate PDF menggunakan Browsershot
        try {
            Browsershot::html($html)
                // ->setNodeBinary(env('NODE_PATH', '/usr/local/bin/node')) // Pastikan path Node.js benar
                // ->setNpmBinary(env('NPM_PATH', '/usr/local/bin/npm'))   // Pastikan path NPM benar
                ->noSandbox() // Penting untuk beberapa lingkungan server
                ->showBackground() // Agar background (misal warna) ikut terrender
                ->format('A4')
                ->save($pdfPath);

            // 5. Kembalikan PDF sebagai response download
            return response()->download($pdfPath, $fileName)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            // Log error untuk debugging
            \Log::error('PDF generation failed: ' . $e->getMessage());
            // Atau return error response
            return response()->json(['status' => false, 'message' => 'Gagal membuat PDF: ' . $e->getMessage()], 500);
        }
    }
}