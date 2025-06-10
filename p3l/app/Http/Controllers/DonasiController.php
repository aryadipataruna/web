<?php
namespace App\Http\Controllers;

use App\Models\Donasi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DonasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // Mengambil semua data dan mengurutkannya berdasarkan ID
            $data = Donasi::orderBy('ID_DONASI', 'asc')->get();

            return response()->json([
                "status"  => true,
                "message" => "Berhasil mendapatkan semua data Donasi!",
                "data"    => $data,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "status"  => false,
                "message" => "Gagal mendapatkan data Donasi!",
                "error"   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi untuk data yang masuk
        $validator = Validator::make($request->all(), [
            'ID_ORGANISASI'      => 'required|string',
            'NAMA_BARANG_DONASI' => 'required|string',
            'TGL_DONASI'         => 'required|date',
            'NAMA_PENERIMA'      => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status"  => false,
                "message" => "Validasi Gagal!",
                "errors"  => $validator->errors(),
            ], 422);
        }

        try {
            // --- Logika Pembuatan ID Manual ---
            // 1. Ambil record terakhir untuk mendapatkan nomor ID tertinggi.
            $lastDonasi = Donasi::orderBy('ID_DONASI', 'desc')->first();

            // 2. Ekstrak bagian angka dari ID terakhir. Jika tidak ada data, mulai dari 0.
            $lastIdNumber = $lastDonasi ? (int) substr($lastDonasi->ID_DONASI, 3) : 0;

            // 3. Tambahkan 1 untuk ID baru.
            $nextIdNumber = $lastIdNumber + 1;

            // 4. Format ID baru dengan prefix 'DON' dan padding '0' hingga 3 digit.
            // Contoh: DON001, DON012, DON123
            $generatedId = 'DON' . str_pad($nextIdNumber, 3, '0', STR_PAD_LEFT);

            // Buat instance Donasi baru
            $donasi = new Donasi();

            // Set ID secara manual dan isi atribut lainnya
            $donasi->ID_DONASI = $generatedId;
            $donasi->fill($validator->validated()); // Mengisi data dari validasi

            // Simpan ke database
            $donasi->save();

            return response()->json([
                "status"  => true,
                "message" => "Donasi berhasil dibuat!",
                "data"    => $donasi,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                "status"  => false,
                "message" => "Gagal membuat Donasi!",
                "error"   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $data = Donasi::find($id);

            if (! $data) {
                return response()->json(['message' => 'ID Donasi tidak ditemukan!'], 404);
            }

            return response()->json([
                "status"  => true,
                "message" => "Berhasil mendapatkan data Donasi!",
                "data"    => $data,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "status"  => false,
                "message" => "Gagal mendapatkan data Donasi!",
                "error"   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi untuk data update. 'sometimes' berarti hanya divalidasi jika ada di request.
        $validator = Validator::make($request->all(), [
            'TGL_DONASI'         => 'sometimes|required|date',
            'NAMA_PENERIMA'      => 'sometimes|required|string',
            // Tambahkan field lain yang bisa di-update jika perlu
            'ID_ORGANISASI'      => 'sometimes|required|string',
            'NAMA_BARANG_DONASI' => 'sometimes|required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status"  => false,
                "message" => "Validasi Gagal!",
                "errors"  => $validator->errors(),
            ], 422);
        }

        try {
            $data = Donasi::find($id);

            if (! $data) {
                return response()->json(['message' => 'ID Donasi tidak ditemukan!'], 404);
            }

            $data->update($validator->validated());

            return response()->json([
                "status"  => true,
                "message" => "Donasi berhasil diperbarui!",
                "data"    => $data,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "status"  => false,
                "message" => "Gagal memperbarui Donasi!",
                "error"   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $data = Donasi::find($id);

            if (! $data) {
                return response()->json(['message' => 'ID Donasi tidak ditemukan!'], 404);
            }

            $data->delete();

            return response()->json([
                "status"  => true,
                "message" => "Berhasil menghapus Donasi!",
                "data"    => $data,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "status"  => false,
                "message" => "Gagal menghapus Donasi!",
                "error"   => $e->getMessage(),
            ], 500);
        }
    }
}
