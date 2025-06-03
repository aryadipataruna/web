<?php
namespace App\Http\Controllers;

use App\Models\Penjualan;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = Penjualan::all();

            return response()->json([
                "status"  => true,
                "message" => "Getting all Penjualan successful!",
                "data"    => $data,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status"  => false,
                "message" => "Getting all Penjualan failed!!!",
                "data"    => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validate incoming request data, exclude id_penjualan as it will be generated
            $validateData = $request->validate([
                'id_pembeli'           => 'required|string',        // NOT NULL
                'id_barang'            => 'required|string',        // NOT NULL (although data sample has empty) - stick to schema
                'id_komisi'            => 'required|string',        // NOT NULL
                'id_pegawai'           => 'required|string',        // NOT NULL
                'tgl_pesan'            => 'required|date',          // NOT NULL
                'tgl_kirim'            => 'nullable|date',          // NULL
                'tgl_ambil'            => 'nullable|date',          // NULL
                'status'               => 'required|string|max:50', // NOT NULL, added max length
                'jenis_pengantaran'    => 'required|string|max:50', // NOT NULL, added max length
                'tgl_pembayaran'       => 'nullable|date',          // NULL
                'total_ongkir'         => 'nullable|numeric',       // NULL
                'harga_setelah_ongkir' => 'nullable|numeric',       // NULL
                'potongan_harga'       => 'nullable|numeric',       // NULL
                'total_harga'          => 'required|numeric',       // NOT NULL
            ]);

            // Generate unique id_penjualan (e.g., PENJ001, PENJ002, ...)
            // Find the last Penjualan record to get the highest ID number
            $lastPenjualan = Penjualan::orderBy('id_penjualan', 'desc')->first();

            // Extract the numeric part from the last ID, or start with 0 if no records exist
            // Assumes ID format is PENJ + 3 digits
            $lastIdNumber = $lastPenjualan ? (int) substr($lastPenjualan->id_penjualan, 4) : 0;

            // Increment the number for the new ID
            $nextIdNumber = $lastIdNumber + 1;

            // Format the new ID with the prefix 'PENJ' and pad with leading zeros to 3 digits
            $generatedId = 'PENJ' . str_pad($nextIdNumber, 3, '0', STR_PAD_LEFT);

                                                                     // Create a new Penjualan instance and set the generated ID and other data
            $penjualan               = new Penjualan($validateData); // Fill other attributes using mass assignment
            $penjualan->id_penjualan = $generatedId;                 // Manually set the generated primary key
            $penjualan->save();                                      // Save the model to the database

            return response()->json([
                "status"  => true,
                "message" => "Penjualan successfully created!",
                "data"    => $penjualan,
            ], 201); // Use 201
        } catch (\Exception $e) {
            return response()->json([
                "status"  => false,
                "message" => "Failed at creating the Penjualan!",
                "data"    => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $data = Penjualan::find($id);

            if (! $data) {
                return response()->json(['message' => 'Penjualan ID not found!!!'], 404);
            }

            return response()->json([
                "status"  => true,
                "message" => "Getting the selected Penjualan successful!",
                "data"    => $data,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status"  => false,
                "message" => "Getting the selected Penjualan failed!!!",
                "data"    => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = Penjualan::find($id);

            if (! $data) {
                return response()->json(['message' => 'Penjualan ID not found!!!'], 404);
            }

            $validateData = $request->validate([
                'id_pembeli'           => 'required|string',
                'id_barang'            => 'required|string',
                'id_komisi'            => 'required|string',
                'id_pegawai'           => 'required|string',
                'tgl_pesan'            => 'required|date',
                'tgl_kirim'            => 'nullable|date',
                'tgl_ambil'            => 'nullable|date',
                'status'               => 'required|string|max:50',
                'jenis_pengantaran'    => 'required|string|max:50',
                'tgl_pembayaran'       => 'nullable|date',
                'total_ongkir'         => 'nullable|numeric',
                'harga_setelah_ongkir' => 'nullable|numeric',
                'potongan_harga'       => 'nullable|numeric',
                'total_harga'          => 'required|numeric',
            ]);

            $data->update($validateData);

            return response()->json([
                "status"  => true,
                "message" => "Penjualan successfully updated!",
                "data"    => $data,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status"  => false,
                "message" => "Failed at updating the Penjualan!!!",
                "data"    => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $data = Penjualan::find($id);

            if (! $data) {
                return response()->json(['message' => 'Penjualan ID not found!!!'], 404);
            }

            // Consider deleting related Komisi if Komisi cannot exist without Penjualan
            // Note: Komisi belongsTo Penjualan based on your models, so deleting Penjualan
            // might require deleting the associated Komisi record first, or setting up
            // database level cascade deletes.
            if ($data->komisi()->exists()) {
                $data->komisi->delete(); // Example: Cascade delete Komisi
            }

            $data->delete();

            return response()->json([
                "status"  => true,
                "message" => "Successfully deleted the Penjualan!",
                "data"    => $data,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status"  => false,
                "message" => "Failed to delete the Penjualan!!!",
                "data"    => $e->getMessage(),
            ], 400);
        }
    }

    public function generateNotaPdf($nomor_nota)
    {
        // Ambil semua item penjualan yang termasuk dalam nomor_nota ini
        // Eager load relasi untuk efisiensi
        $items = Penjualan::where('nomor_nota', $nomor_nota)
            ->with(['pembeli', 'barang', 'pegawai']) // barang relasi ke tabel barang
            ->get();

        if ($items->isEmpty()) {
            // Jika Anda ingin merender halaman error khusus:
            // return view('errors.nota_tidak_ditemukan', ['nomor_nota' => $nomor_nota]);
            return response()->json(['message' => 'Nota Penjualan dengan nomor ' . htmlspecialchars($nomor_nota) . ' tidak ditemukan!'], 404);
        }

        // Ambil data header dari item pertama (asumsi data pembeli, tgl pesan, dll konsisten untuk satu nota)
        $firstItem = $items->first();
        $pembeli   = $firstItem->pembeli; // Objek pembeli dari relasi

        // Informasi Header Nota dari data item pertama (asumsi konsisten)
        $tanggalPesan     = $firstItem->tgl_pesan;
        $tanggalLunas     = $firstItem->tgl_lunas; // Seharusnya ini level nota/order
        $tanggalAmbil     = $firstItem->tgl_ambil; // Seharusnya ini level nota/order
        $metodePengiriman = $firstItem->jenis_pengantaran;

        // Alamat Pengiriman: Nota di gambar menampilkan alamat pengiriman spesifik order.
        // Jika tidak ada field khusus untuk ini di tabel 'penjualan' atau 'header order',
        // kita gunakan alamat default pembeli.
        $alamatPengiriman = $pembeli->ALAMAT_PEMBELI ?? 'Alamat tidak tersedia';
        if (strtolower($metodePengiriman) == 'diambil sendiri') {
            // Alamat pada nota gambar adalah alamat pembeli, bukan alamat toko pengambilan
            // Jika ingin menampilkan alamat toko, perlu data tambahan.
            // Untuk sekarang, kita tampilkan alamat pembeli dan keterangan diambil sendiri.
        }

        $qcOleh = $firstItem->pegawai ? $firstItem->pegawai->NAMA_PEGAWAI : 'N/A';

        // Kalkulasi Finansial Nota
        $subtotalKeseluruhanBarang = 0;
        foreach ($items as $item) {
            // Asumsi: harga jual item adalah dari relasi barang->harga_barang
            // Jika Anda menyimpan harga jual spesifik saat transaksi di tabel 'penjualan' (misal di kolom 'total_harga' untuk item tsb), gunakan itu.
            // Untuk contoh ini, kita pakai harga dari tabel barang.
            // Kuantitas juga perlu ada, jika tidak ada, diasumsikan 1.
            $hargaItem     = $item->barang->harga_barang ?? 0;
            $kuantitasItem = $item->kuantitas ?? 1; // Jika ada kolom kuantitas di tabel penjualan
            $subtotalKeseluruhanBarang += ($hargaItem * $kuantitasItem);
        }

                                                         // Ongkos Kirim: Ini adalah biaya level NOTA.
                                                         // Jika 'total_ongkir' di tabel 'penjualan' adalah ongkir per item, ini perlu dijumlahkan.
                                                         // Jika 'total_ongkir' diduplikasi untuk semua item dalam nota yang sama, ambil dari item pertama.
                                                         // Nota pada gambar menunjukkan satu ongkos kirim untuk keseluruhan.
        $ongkosKirim = $firstItem->total_ongkir ?? 0.00; // Ambil dari item pertama, asumsi ini ongkir keseluruhan nota

                                   // Data Poin: Ini adalah informasi level NOTA dan idealnya disimpan di tabel header order.
                                   // Karena tidak ada di model 'Penjualan' Anda untuk transaksi spesifik ini:
        $poinDigunakan     = 0;    // Default, karena tidak ada kolom di 'penjualan' untuk ini per-nota
        $nilaiPotonganPoin = 0.00; // Default
        $poinDiperoleh     = 0;    // Default

        // Jika Anda memiliki cara untuk mengambil informasi ini berdasarkan $nomor_nota (misalnya dari tabel lain atau logika bisnis)
        // $dataOrderHeader = $this->getOrderHeaderData($nomor_nota); // fungsi hipotetis
        // $poinDigunakan = $dataOrderHeader->poin_digunakan_untuk_nota_ini ?? 0;
        // $nilaiPotonganPoin = $dataOrderHeader->nilai_potongan_untuk_nota_ini ?? 0.00;
        // $poinDiperoleh = $dataOrderHeader->poin_diperoleh_dari_nota_ini ?? 0;
        // $ongkosKirim = $dataOrderHeader->ongkos_kirim_nota ?? $ongkosKirim; // Prioritaskan dari header jika ada

        $totalSebelumPotongan = $subtotalKeseluruhanBarang + $ongkosKirim;
        $totalAkhirDibayar    = $totalSebelumPotongan - $nilaiPotonganPoin;

        // Total Poin Customer: Ini adalah poin customer SETELAH transaksi ini.
        // `pembeli->POIN_PEMBELI` biasanya adalah poin aktual/sebelumnya.
        // Untuk mencerminkan nota "Total poin customer: 300", Anda perlu:
        // Poin Saat Ini = (Poin Pembeli Sebelum Transaksi) - poinDigunakan + poinDiperoleh;
        // Karena kita tidak memiliki data poin historis per transaksi ini dari tabel,
        // kita tampilkan poin pembeli saat ini.
        $totalPoinCustomer = $pembeli->POIN_PEMBELI ?? 0;

        $dataUntukPdf = [
            'nomor_nota'                => $nomor_nota,
            'items'                     => $items,   // Collection of Penjualan objects
            'pembeli'                   => $pembeli, // Pembeli object
            'tanggalPesan'              => $tanggalPesan,
            'tanggalLunas'              => $tanggalLunas,
            'tanggalAmbil'              => $tanggalAmbil,
            'alamatPengiriman'          => $alamatPengiriman,
            'metodePengiriman'          => $metodePengiriman,
            'subtotalKeseluruhanBarang' => $subtotalKeseluruhanBarang,
            'ongkosKirim'               => $ongkosKirim,
            'poinDigunakan'             => $poinDigunakan,
            'nilaiPotonganPoin'         => $nilaiPotonganPoin,
            'totalAkhirDibayar'         => $totalAkhirDibayar,
            'poinDiperoleh'             => $poinDiperoleh,
            'totalPoinCustomer'         => $totalPoinCustomer,
            'qcOleh'                    => $qcOleh,
        ];

        try {
            $pdf = PDF::loadView('pdfs.nota_pembelian', $dataUntukPdf);
            // $pdf->setPaper('a5', 'portrait'); // Anda bisa atur ukuran kertas jika perlu
            return $pdf->stream('nota-' . $nomor_nota . '.pdf');
        } catch (\Exception $e) {
            // Log error atau return response error yang lebih informatif
            \Log::error("Gagal membuat PDF untuk nota {$nomor_nota}: " . $e->getMessage());
            return response()->json([
                "status"  => false,
                "message" => "Gagal membuat PDF! Silakan coba lagi nanti.",
                // "error_detail" => $e->getMessage() // Hati-hati menampilkan detail error ke user
            ], 500);
        }
    }
}
