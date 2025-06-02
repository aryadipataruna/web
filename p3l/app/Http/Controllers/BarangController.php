<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Import Str facade for string manipulation
use Carbon\Carbon;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = Barang::all();

            return response()->json([
                "status" => true,
                "message" => "Getting all Barang successful!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Getting all Barang failed!!!",
                "data" => $e->getMessage()
            ], 400);
        }
    }

    public function produkTerjual()
    {
        try {
            $data = Barang::where('status', 'terjual')->get();

            if ($data->isEmpty()) {
                return response()->json([
                    "status" => true, // Status true karena permintaan berhasil, hanya datanya kosong
                    "message" => "Tidak ada barang dengan status 'terjual' ditemukan.",
                    "data" => [] 
                ], 200); 
            }

            return response()->json([
                "status" => true,
                "message" => "Berhasil mendapatkan semua barang dengan status 'terjual'.",
                "data" => $data
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Gagal mendapatkan barang dengan status 'terjual'. " . $e->getMessage(),
                "data" => null // Lebih baik mengembalikan null atau pesan error yang lebih spesifik di 'data'
            ], 500); // Gunakan 500 Internal Server Error untuk kesalahan server
        }
    }

    public function produkTersedia()
    {
        try {
            $data = Barang::where('status', "tersedia")->get();

            if ($data->isEmpty()) {
                return response()->json([
                    "status" => true,
                    "message" => "Tidak ada barang dengan status 'tersedia' ditemukan.",
                    "data" => []
                ], 200);
            }

            return response()->json([
                "status" => true,
                "message" => "Berhasil mendapatkan semua barang dengan status 'tersedia'.",
                "data" => $data
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Gagal mendapatkan barang dengan status 'tersedia'. " . $e->getMessage(),
                "data" => null
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validate incoming request data, exclude id_barang as it will be generated
            $validateData = $request->validate([
                'id_penitip' => 'required|string', // NOT NULL in DB
                'id_diskusi' => 'nullable|string', // NULL in DB
                'id_pegawai' => 'required|string', // NOT NULL in DB
                'nama_barang' => 'required|string', // NOT NULL in DB
                'deskripsi_barang' => 'required|string', // NOT NULL in DB
                'kategori' => 'required|string', // NOT NULL in DB
                'harga_barang' => 'required|numeric', // NOT NULL in DB
                'tgl_titip' => 'nullable|date', // NOT NULL in DB
                'tgl_laku' => 'nullable|date', // NULL in DB
                'tgl_akhir' => 'nullable|date',
                'garansi' => 'required|boolean', // NOT NULL in DB (tinyint)
                'perpanjangan' => 'nullable|boolean', // NOT NULL in DB (tinyint)
                'count_perpanjangan' => 'nullable|integer', // NOT NULL in DB
                'status' => 'nullable|string', // NULL in DB
                'gambar_barang' => 'required|string',
                'bukti_pembayaran' => 'nullable|string', // NOT NULL in DB
            ]);

             // Generate unique id_barang (e.g., BAR001, BAR002, ...)
            // Find the last Barang record to get the highest ID number
            $lastBarang = Barang::orderBy('id_barang', 'desc')->first();

            // Extract the numeric part from the last ID, or start with 0 if no records exist
            // Assumes ID format is BAR + 3 digits
            $lastIdNumber = $lastBarang ? (int) substr($lastBarang->id_barang, 3) : 0;

            // Increment the number for the new ID
            $nextIdNumber = $lastIdNumber + 1;

            // Format the new ID with the prefix 'BAR' and pad with leading zeros to 3 digits
            $generatedId = 'BAR' . str_pad($nextIdNumber, 3, '0', STR_PAD_LEFT);

            $barang->tgl_titip = Carbon::now()->toDateString(); // Tanggal hari ini
            $barang->tgl_akhir = Carbon::now()->addDays(30)->toDateString(); // Tanggal titip + 30 hari
            $barang->perpanjangan = false; // Inisialisasi
            $barang->count_perpanjangan = 0; // Inisialisasi

            // Buat instance Barang baru dan set ID yang di-generate dan data lainnya
            $barang = new Barang($validateData); // Isi atribut lain menggunakan mass assignment
            $barang->id_barang = $generatedId; // Set primary key yang di-generate

            $barang->save(); // Simpan model ke database


            return response()->json([
                "status" => true,
                "message" => "Barang successfully created!",
                "data" => $barang,
            ], 201); // Use 201
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Failed at creating the Barang!",
                "data" => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $data = Barang::find($id);

            if (!$data) {
                return response()->json(['message' => 'Barang ID not found!!!'], 404);
            }

            return response()->json([
                "status" => true,
                "message" => "Getting the selected Barang successful!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Getting the selected Barang failed!!!",
                "data" => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = Barang::find($id);

            if (!$data) {
                return response()->json(['message' => 'Barang ID not found!!!'], 404);
            }

            $validateData = $request->validate([
                'id_penitip' => 'required|string',
                'id_diskusi' => 'nullable|string',
                'id_pegawai' => 'required|string',
                'nama_barang' => 'required|string',
                'deskripsi_barang' => 'required|string',
                'kategori' => 'required|string',
                'harga_barang' => 'required|numeric',
                'tgl_titip' => 'nullable|date',
                'tgl_laku' => 'nullable|date',
                'tgl_akhir' => 'nullable|date',
                'garansi' => 'required|boolean',
                'perpanjangan' => 'nullable|boolean',
                'count_perpanjangan' => 'nullable|integer',
                'status' => 'nullable|string',
                'gambar_barang' => 'required|string',
                'bukti_pembayaran' => 'nullable|string',
            ]);

            $data->update($validateData);

            return response()->json([
                "status" => true,
                "message" => "Barang successfully updated!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Failed at updating the Barang!!!",
                "data" => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $data = Barang::find($id);

            if (!$data) {
                return response()->json(['message' => 'Barang ID not found!!!'], 404);
            }

            $data->delete();

            return response()->json([
                "status" => true,
                "message" => "Successfully deleted the Barang!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Failed to delete the Barang!!!",
                "data" => $e->getMessage()
            ], 400);
        }
    }

    public function extend(Request $request, $id)
    {
        try {
            $barang = Barang::findOrFail($id);

            $today = Carbon::now()->toDateString(); // Tanggal hari ini (YYYY-MM-DD)
            $tglAkhirBarang = Carbon::parse($barang->tgl_akhir)->toDateString(); // Tanggal akhir barang

            // Cek apakah tgl_akhir barang sama dengan hari ini
            if ($tglAkhirBarang !== $today) {
                return response()->json([
                    'status' => false,
                    'message' => 'Perpanjangan hanya bisa dilakukan pada tanggal akhir titip (hari ini).'
                ], 400); // Bad Request
            }

            // Cek apakah perpanjangan maksimal sudah tercapai (2 kali)
            if ($barang->count_perpanjangan >= 2) {
                return response()->json([
                    'status' => false,
                    'message' => 'Perpanjangan maksimal sudah tercapai (2 kali).'
                ], 400); // Bad Request
            }

            // Update consignment details
            $barang->count_perpanjangan += 1;
            $barang->perpanjangan = true; // Tandai bahwa barang telah diperpanjang
            $barang->tgl_akhir = Carbon::parse($tglAkhirBarang)->addDays(30)->toDateString(); // Perpanjang 30 hari dari tgl_akhir sebelumnya

            $barang->save();

            return response()->json([
                'status' => true,
                'message' => 'Masa titip barang berhasil diperpanjang! (Perpanjangan ke-' . $barang->count_perpanjangan . ')',
                'data' => $barang
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memperpanjang masa titip: ' . $e->getMessage()
            ], 500); // Internal Server Error
        }
    }

    public function showBarangRating($id)
    {
        // Temukan barang berdasarkan ID
        $barang = Barang::find($id);

        // Jika barang tidak ditemukan
        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Barang tidak ditemukan.'
            ], 404);
        }

        // Ambil rating dari relasi di model Barang (hasOne)
        $ratingData = $barang->rating;

        // Jika tidak ada rating yang ditemukan untuk barang ini di tabel 'ratings'
        if (!$ratingData) {
            return response()->json([
                'success' => true,
                'message' => 'Barang ini belum memiliki rating.',
                'rating'  => null // Mengembalikan null jika belum ada rating
            ], 200);
        }

        // Jika rating ditemukan
        return response()->json([
            'success' => true,
            'message' => 'Rating barang ditemukan.',
            'rating'  => $barang->rating 
        ]);
    }

    public function inputBarangRating(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            // Pastikan id_barang adalah string karena di model Barang $keyType = 'string'
            'id' => 'required|string|exists:barang,id_barang',
            'rating'    => 'required|integer|min:1|max:5',
        ]);

        $idBarang = $request->id;
        $nilaiRating = $request->rating;

        // 2. Cari barang berdasarkan id_barang
        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Barang tidak ditemukan.'
            ], 404);
        }

        // 3. Ambil id_penitip dari barang yang terkait
        // Pastikan relasi 'penitip' di model Barang sudah benar
        $idPenitip = $barang->id_penitip;

        if (!$idPenitip) {
            return response()->json([
                'success' => false,
                'message' => 'Barang ini tidak memiliki penitip yang terkait.'
            ], 400);
        }

        // Menggunakan updateOrCreate untuk membuat atau memperbarui rating
        $rating = Rating::updateOrCreate(
            ['id_barang' => $idBarang], // Kriteria pencarian: cari rating berdasarkan id_barang
            [
                'id_penitip' => $idPenitip,
                'rating'     => $nilaiRating,
                'nama_barang'=> $barang->nama_barang // Mengambil nama barang dari objek barang
            ] // Data yang akan di-update atau dibuat
        );

        $message = $rating->wasRecentlyCreated ? 'Terima kasih telah memberi rating!' : 'Rating Anda berhasil diperbarui!';

        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $rating // Mengembalikan data rating yang baru disimpan/diperbarui
        ]);
    }
}