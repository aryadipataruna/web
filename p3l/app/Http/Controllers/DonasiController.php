<?php

namespace App\Http\Controllers;

use App\Models\Donasi;
use Illuminate\Http\Request;

class DonasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = Donasi::all();

            return response()->json([
                "status" => true,
                "message" => "Getting all Donasi successful!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Getting all Donasi failed!!!",
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
            // Validate incoming request data, exclude ID_DONASI as it will be generated
            $validateData = $request->validate([
                'ID_ORGANISASI' => 'required|string', // NOT NULL in DB
                'NAMA_BARANG_DONASI' => 'required|string', // NOT NULL in DB
                'TGL_DONASI' => 'required|date', // NOT NULL in DB
                'NAMA_PENERIMA' => 'required|string', // NOT NULL in DB
            ]);

            // Generate unique ID_DONASI (e.g., DON001, DON002, ...)
            // Find the last Donasi record to get the highest ID number
            $lastDonasi = Donasi::orderBy('ID_DONASI', 'desc')->first();

            // Extract the numeric part from the last ID, or start with 0 if no records exist
            // Assumes ID format is DON + 3 digits
            $lastIdNumber = $lastDonasi ? (int) substr($lastDonasi->ID_DONASI, 3) : 0;

            // Increment the number for the new ID
            $nextIdNumber = $lastIdNumber + 1;

            // Format the new ID with the prefix 'DON' and pad with leading zeros to 3 digits
            $generatedId = 'DON' . str_pad($nextIdNumber, 3, '0', STR_PAD_LEFT);

            // Create a new Donasi instance and set the generated ID and other data
            $donasi = new Donasi($validateData); // Fill other attributes using mass assignment
            $donasi->ID_DONASI = $generatedId; // Manually set the generated primary key
            $donasi->save(); // Save the model to the database


            return response()->json([
                "status" => true,
                "message" => "Donasi successfully created!",
                "data" => $donasi,
            ], 201); // Use 201
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Failed at creating the Donasi!",
                "data" => $e->getMessage(),
            ], 400);
        }
    }

    public function show($id)
    {
        try {
            $data = Donasi::find($id);

            if (!$data) {
                return response()->json(['message' => 'Donasi ID not found!!!'], 404);
            }

            return response()->json([
                "status" => true,
                "message" => "Getting the selected Donasi successful!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Getting the selected Donasi failed!!!",
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
            $data = Donasi::find($id);

            if (!$data) {
                return response()->json(['message' => 'Donasi ID not found!!!'], 404);
            }

            $validateData = $request->validate([
                'TGL_DONASI' => 'required|date',
                'NAMA_PENERIMA' => 'required|string',
            ]);

            $data->update($validateData);

            return response()->json([
                "status" => true,
                "message" => "Donasi successfully updated!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Failed at updating the Donasi!!!",
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
            $data = Donasi::find($id);

            if (!$data) {
                return response()->json(['message' => 'Donasi ID not found!!!'], 404);
            }

            $data->delete();

            return response()->json([
                "status" => true,
                "message" => "Successfully deleted the Donasi!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Failed to delete the Donasi!!!",
                "data" => $e->getMessage()
            ], 400);
        }
    }
}