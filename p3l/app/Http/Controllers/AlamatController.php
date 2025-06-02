<?php

namespace App\Http\Controllers;

use App\Models\Alamat;
use Illuminate\Http\Request;

class AlamatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = Alamat::all();

            return response()->json([
                "status" => true,
                "message" => "Getting all Alamat successful!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Getting all Alamat failed!!!",
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
            // Validate incoming request data, exclude ID_ALAMAT as it will be generated
            $validateData = $request->validate([
                'ID_PEMBELI' => 'nullable|string',
                'ID_ORGANISASI' => 'nullable|string',
                'DESKRIPSI_ALAMAT' => 'required|string', // NOT NULL in DB
            ]);

            // Generate unique ID_ALAMAT (e.g., ALM001, ALM002, ...)
            // Find the last Alamat record to get the highest ID number
            $lastAlamat = Alamat::orderBy('ID_ALAMAT', 'desc')->first();

            // Extract the numeric part from the last ID, or start with 0 if no records exist
            // Assumes ID format is ALM + 3 digits
            $lastIdNumber = $lastAlamat ? (int) substr($lastAlamat->ID_ALAMAT, 3) : 0;

            // Increment the number for the new ID
            $nextIdNumber = $lastIdNumber + 1;

            // Format the new ID with the prefix 'ALM' and pad with leading zeros to 3 digits
            $generatedId = 'ALM' . str_pad($nextIdNumber, 3, '0', STR_PAD_LEFT);

            // Create a new Alamat instance and set the generated ID and other data
            $alamat = new Alamat($validateData); // Fill other attributes using mass assignment
            $alamat->ID_ALAMAT = $generatedId; // Manually set the generated primary key
            $alamat->save(); // Save the model to the database

            return response()->json([
                "status" => true,
                "message" => "Alamat successfully created!",
                "data" => $alamat,
            ], 201); // Use 201 for created resource
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Failed at creating the Alamat!",
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
            $data = Alamat::find($id);

            if (!$data) {
                return response()->json(['message' => 'Alamat ID not found!!!'], 404); // Use 404 for Not Found
            }

            return response()->json([
                "status" => true,
                "message" => "Getting the selected Alamat successful!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Getting the selected Alamat failed!!!",
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
            $data = Alamat::find($id);

            if (!$data) {
                return response()->json(['message' => 'Alamat ID not found!!!'], 404); // Use 404
            }

            $validateData = $request->validate([
                'ID_PEMBELI' => 'nullable|string',
                'ID_ORGANISASI' => 'nullable|string',
                'DESKRIPSI_ALAMAT' => 'required|string',
            ]);

            $data->update($validateData);

            return response()->json([
                "status" => true,
                "message" => "Alamat successfully updated!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Failed at updating the Alamat!!!",
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
            $data = Alamat::find($id);

            if (!$data) {
                return response()->json(['message' => 'Alamat ID not found!!!'], 404); // Use 404
            }

            $data->delete();

            return response()->json([
                "status" => true,
                "message" => "Successfully deleted the Alamat!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Failed to delete the Alamat!!!",
                "data" => $e->getMessage()
            ], 400);
        }
    }
}