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
                "status" => true,
                "message" => "Getting all Penjualan successful!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Getting all Penjualan failed!!!",
                "data" => $e->getMessage()
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
                'id_pembeli' => 'required|string', // NOT NULL
                'id_barang' => 'required|string', // NOT NULL (although data sample has empty) - stick to schema
                'id_komisi' => 'required|string', // NOT NULL
                'id_pegawai' => 'required|string', // NOT NULL
                'tgl_pesan' => 'required|date', // NOT NULL
                'tgl_kirim' => 'nullable|date', // NULL
                'tgl_ambil' => 'nullable|date', // NULL
                'status' => 'required|string|max:50', // NOT NULL, added max length
                'jenis_pengantaran' => 'required|string|max:50', // NOT NULL, added max length
                'tgl_pembayaran' => 'nullable|date', // NULL
                'total_ongkir' => 'nullable|numeric', // NULL
                'harga_setelah_ongkir' => 'nullable|numeric', // NULL
                'potongan_harga' => 'nullable|numeric', // NULL
                'total_harga' => 'required|numeric', // NOT NULL
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
            $penjualan = new Penjualan($validateData); // Fill other attributes using mass assignment
            $penjualan->id_penjualan = $generatedId; // Manually set the generated primary key
            $penjualan->save(); // Save the model to the database


            return response()->json([
                "status" => true,
                "message" => "Penjualan successfully created!",
                "data" => $penjualan,
            ], 201); // Use 201
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Failed at creating the Penjualan!",
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
            $data = Penjualan::find($id);

            if (!$data) {
                return response()->json(['message' => 'Penjualan ID not found!!!'], 404);
            }

            return response()->json([
                "status" => true,
                "message" => "Getting the selected Penjualan successful!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Getting the selected Penjualan failed!!!",
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
            $data = Penjualan::find($id);

            if (!$data) {
                return response()->json(['message' => 'Penjualan ID not found!!!'], 404);
            }

             $validateData = $request->validate([
                'id_pembeli' => 'required|string',
                'id_barang' => 'required|string',
                'id_komisi' => 'required|string',
                'id_pegawai' => 'required|string',
                'tgl_pesan' => 'required|date',
                'tgl_kirim' => 'nullable|date',
                'tgl_ambil' => 'nullable|date',
                'status' => 'required|string|max:50',
                'jenis_pengantaran' => 'required|string|max:50',
                'tgl_pembayaran' => 'nullable|date',
                'total_ongkir' => 'nullable|numeric',
                'harga_setelah_ongkir' => 'nullable|numeric',
                'potongan_harga' => 'nullable|numeric',
                'total_harga' => 'required|numeric',
            ]);


            $data->update($validateData);

            return response()->json([
                "status" => true,
                "message" => "Penjualan successfully updated!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Failed at updating the Penjualan!!!",
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
            $data = Penjualan::find($id);

            if (!$data) {
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
                "status" => true,
                "message" => "Successfully deleted the Penjualan!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Failed to delete the Penjualan!!!",
                "data" => $e->getMessage()
            ], 400);
        }
    }
}