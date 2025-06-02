<?php

namespace App\Http\Controllers;

use App\Models\Rating; // Menggunakan model Rating (singular)
use App\Models\Barang; // Menggunakan model Barang (singular)
use App\Models\Penitip; // Menggunakan model Penitip (singular)
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse; // Tambahkan ini untuk respons JSON

class RatingController extends Controller
{
    /**
     * Store or update a rating for a specific barang.
     * Since a barang can only have one rating, this method will
     * create a new rating if it doesn't exist, or update it if it does.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeOrUpdate(Request $request): JsonResponse
    {
        // 1. Validasi input
        $request->validate([
            // Jika id_barang adalah UUID atau string lainnya
            'id_barang' => 'required|string|exists:barang,id_barang',// Pastikan id_barang ada di tabel 'barang'
            'rating'    => 'required|integer|min:1|max:5',
        ]);

        $idBarang = $request->id_barang;
        $nilaiRating = $request->rating;

        // 2. Cari barang berdasarkan id_barang
        $barang = Barang::find($idBarang);

        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Barang tidak ditemukan.'
            ], 404);
        }

        // 3. Ambil id_penitip dari barang yang terkait
        $idPenitip = $barang->id_penitip;

        if (!$idPenitip) {
            return response()->json([
                'success' => false,
                'message' => 'Barang ini tidak memiliki penitip yang terkait.'
            ], 400);
        }

        // 4. Cari rating yang sudah ada untuk barang ini
        // Karena relasi One-to-One, kita cari berdasarkan id_barang
        $rating = Rating::where('id_barang', $idBarang)->first();

        if ($rating) {
            // Jika rating sudah ada, perbarui nilainya
            $rating->rating = $nilaiRating;
            $rating->save();
            $message = 'Rating Anda berhasil diperbarui!';
        } else {
            // Jika rating belum ada, buat yang baru
            $rating = new Rating();
            $rating->id_barang = $idBarang;
            $rating->id_penitip = $idPenitip;
            $rating->rating = $nilaiRating;
            $rating->nama_barang = $barang->nama_barang; // Mengambil nama barang dari objek barang
            $rating->save();
            $message = 'Terima kasih telah memberi rating!';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $rating // Mengembalikan data rating yang baru disimpan/diperbarui
        ]);
    }

    /**
     * Display the single rating for a specific barang.
     *
     * @param  string  $id_barang
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBarangRating(string $id_barang): JsonResponse
    {
        $barang = Barang::find($id_barang);

        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Barang tidak ditemukan.'
            ], 404);
        }

        // Mengambil rating tunggal menggunakan relasi hasOne
        $rating = $barang->rating; // Memanggil relasi 'rating' dari model Barang

        if (!$rating) {
            return response()->json([
                'success' => true,
                'message' => 'Barang ini belum memiliki rating.',
                'rating'  => null
            ], 200);
        }

        return response()->json([
            'success' => true,
            'message' => 'Rating barang ditemukan.',
            'rating'  => $rating->rating // Mengembalikan nilai rating saja
        ]);
    }

    /**
     * Display the average rating for a specific penitip.
     *
     * @param  int  $id_penitip
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPenitipRating(string $id_penitip): JsonResponse
    {
        $penitip = Penitip::find($id_penitip);

        if (!$penitip) {
            return response()->json([
                'success' => false,
                'message' => 'Penitip tidak ditemukan.'
            ], 404);
        }

        // Mengambil rata-rata rating yang diterima oleh penitip
        $averageRating = $penitip->ratings()->avg('rating');
        $ratingsCount = $penitip->ratings()->count();

        return response()->json([
            'success'         => true,
            'message'         => 'Rata-rata rating penitip.',
            'average_rating'  => $averageRating,
            'ratings_count'   => $ratingsCount
        ]);
    }
}