<?php

namespace App\Http\Controllers;

use App\Models\Komisi;
use Illuminate\Http\Request;

class KomisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = Komisi::all();

            return response()->json([
                "status" => true,
                "message" => "Getting all Komisi successful!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Getting all Komisi failed!!!",
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
            // Validate incoming request data, exclude id_komisi as it will be generated
            $validateData = $request->validate([
                'id_penjualan' => 'required|string', // NOT NULL in DB
                'id_pegawai' => 'nullable|string', // NULL in DB sample data, though not explicitly NULL in schema
                'komisi_perusahaan' => 'nullable|numeric', // NULL in DB
                'komisi_hunter' => 'nullable|numeric', // NULL in DB
                'bonus' => 'nullable|numeric', // NULL in DB
            ]);

            // Generate unique id_komisi (e.g., KOM001, KOM002, ...)
            // Find the last Komisi record to get the highest ID number
            $lastKomisi = Komisi::orderBy('id_komisi', 'desc')->first();

            // Extract the numeric part from the last ID, or start with 0 if no records exist
            // Assumes ID format is KOM + 3 digits
            $lastIdNumber = $lastKomisi ? (int) substr($lastKomisi->id_komisi, 3) : 0;

            // Increment the number for the new ID
            $nextIdNumber = $lastIdNumber + 1;

            // Format the new ID with the prefix 'KOM' and pad with leading zeros to 3 digits
            $generatedId = 'KOM' . str_pad($nextIdNumber, 3, '0', STR_PAD_LEFT);

            // Create a new Komisi instance and set the generated ID and other data
            $komisi = new Komisi($validateData); // Fill other attributes using mass assignment
            $komisi->id_komisi = $generatedId; // Manually set the generated primary key
            $komisi->save(); // Save the model to the database


            return response()->json([
                "status" => true,
                "message" => "Komisi successfully created!",
                "data" => $komisi,
            ], 201); // Use 201
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Failed at creating the Komisi!",
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
            $data = Komisi::find($id);

            if (!$data) {
                return response()->json(['message' => 'Komisi ID not found!!!'], 404);
            }

            return response()->json([
                "status" => true,
                "message" => "Getting the selected Komisi successful!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Getting the selected Komisi failed!!!",
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
            $data = Komisi::find($id);

            if (!$data) {
                return response()->json(['message' => 'Komisi ID not found!!!'], 404);
            }

            $validateData = $request->validate([
                'id_penjualan' => 'required|string',
                'id_pegawai' => 'nullable|string',
                'komisi_perusahaan' => 'nullable|numeric',
                'komisi_hunter' => 'nullable|numeric',
                'bonus' => 'nullable|numeric',
            ]);

            $data->update($validateData);

            return response()->json([
                "status" => true,
                "message" => "Komisi successfully updated!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Failed at updating the Komisi!!!",
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
            $data = Komisi::find($id);

            if (!$data) {
                return response()->json(['message' => 'Komisi ID not found!!!'], 404);
            }

            // Consider checking for related records in 'penjualan' if Penjualan has a BelongsTo Komisi relationship
            // although the schema has komisi.id_penjualan, implying Komisi belongs to Penjualan

            $data->delete();

            return response()->json([
                "status" => true,
                "message" => "Successfully deleted the Komisi!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Failed to delete the Komisi!!!",
                "data" => $e->getMessage()
            ], 400);
        }
    }
}