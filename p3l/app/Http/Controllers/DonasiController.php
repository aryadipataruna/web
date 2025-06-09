<?php
namespace App\Http\Controllers;

use App\Models\Donasi;
use Exception;
use Illuminate\Http\Request; // Import Validator
use Illuminate\Support\Facades\Validator;
// Import Exception

class DonasiController extends Controller
{
    /**
     * Menampilkan semua data donasi.
     */
    public function index()
    {
        try {
            $data = Donasi::orderBy('tgl_donasi', 'desc')->get();

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
     * Menyimpan data donasi baru.
     */
    public function store(Request $request)
    {
        // PERUBAHAN 1: Sesuaikan validasi dengan nama kolom di database Anda
        $validator = Validator::make($request->all(), [
            'kode_produk'   => 'required|string',
            'nama_produk'   => 'required|string',
            'id_penitip'    => 'required|string',
            'nama_penitip'  => 'required|string',
            'tgl_donasi'    => 'required|date',
            'organisasi'    => 'required|string',
            'nama_penerima' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status"  => false,
                "message" => "Validasi Gagal!",
                "errors"  => $validator->errors(),
            ], 422);
        }

        try {
            // PERUBAHAN 2: Hapus logika pembuatan ID manual.
            // Gunakan metode create() yang lebih sederhana karena ID sudah auto-increment.
            $donasi = Donasi::create($validator->validated());

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
     * Menampilkan satu data donasi spesifik.
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
     * Memperbarui data donasi.
     */
    public function update(Request $request, $id)
    {
        // PERUBAHAN 3: Sesuaikan validasi untuk update
        $validator = Validator::make($request->all(), [
            'kode_produk'   => 'sometimes|required|string',
            'nama_produk'   => 'sometimes|required|string',
            'id_penitip'    => 'sometimes|required|string',
            'nama_penitip'  => 'sometimes|required|string',
            'tgl_donasi'    => 'sometimes|required|date',
            'organisasi'    => 'sometimes|required|string',
            'nama_penerima' => 'sometimes|required|string',
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
     * Menghapus data donasi.
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
