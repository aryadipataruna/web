<?php

namespace App\Http\Controllers;

use App\Models\Diskusi;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Import Str facade for string manipulation

class DiskusiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // Due to the potential PK inconsistency, fetching all might be fine,
            // but relationships might be complex depending on the *intended* structure.
            $data = Diskusi::all();

            return response()->json([
                "status" => true,
                "message" => "Getting all Diskusi successful!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Getting all Diskusi failed!!!",
                "data" => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // IMPORTANT: The SQL dump defines ID_PENITIP as PK in 'diskusi',
        // but the model defines ID_DISKUSI as PK.
        // This controller assumes ID_DISKUSI is the unique identifier generated here.
        try {
            // Validate incoming request data - Add id_barang validation
            $validateData = $request->validate([
                'ID_PENITIP' => 'required|string',
                'ID_PEMBELI' => 'required|string',
                'ID_BARANG' => 'required|string', // Added validation for id_barang
            ]);

            // Generate unique ID_DISKUSI (e.g., DISK001, DISK002, ...)
            // Find the last Diskusi record to get the highest ID number
            $lastDiskusi = Diskusi::orderBy('ID_DISKUSI', 'desc')->first();

            // Extract the numeric part from the last ID, or start with 0 if no records exist
            // Assumes ID format is DISK + 3 digits
            $lastIdNumber = $lastDiskusi ? (int) substr($lastDiskusi->ID_DISKUSI, 4) : 0;

            // Increment the number for the new ID
            $nextIdNumber = $lastIdNumber + 1;

            // Format the new ID with the prefix 'DISK' and pad with leading zeros to 3 digits
            $generatedId = 'DISK' . str_pad($nextIdNumber, 3, '0', STR_PAD_LEFT);

            // Create a new Diskusi instance and set the generated ID and other data
            $diskusi = new Diskusi($validateData); // Fill other attributes using mass assignment
            $diskusi->ID_DISKUSI = $generatedId; // Manually set the generated primary key
            // id_barang will be set via mass assignment from $validateData
            $diskusi->save(); // Save the model to the database


            return response()->json([
                "status" => true,
                "message" => "Diskusi successfully created!",
                "data" => $diskusi,
            ], 201); // Use 201
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Failed at creating the Diskusi!",
                "data" => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
         // Using the model's defined primary key (ID_DISKUSI) for find
        try {
            $data = Diskusi::find($id);

            if (!$data) {
                return response()->json(['message' => 'Diskusi ID not found!!!'], 404);
            }

            return response()->json([
                "status" => true,
                "message" => "Getting the selected Diskusi successful!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Getting the selected Diskusi failed!!!",
                "data" => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
         // Using the model's defined primary key (ID_DISKUSI) for find/update
        try {
            $data = Diskusi::find($id);

            if (!$data) {
                return response()->json(['message' => 'Diskusi ID not found!!!'], 404);
            }

            // Validate incoming request data - Add id_barang validation
            $validateData = $request->validate([
                'ID_PENITIP' => 'required|string',
                'ID_PEMBELI' => 'required|string',
                'ID_BARANG' => 'required|string', // Added validation for id_barang
            ]);

            $data->update($validateData);

            return response()->json([
                "status" => true,
                "message" => "Diskusi successfully updated!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Failed at updating the Diskusi!!!",
                "data" => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Using the model's defined primary key (ID_DISKUSI) for find/delete
        try {
            $data = Diskusi::find($id);

            if (!$data) {
                return response()->json(['message' => 'Diskusi ID not found!!!'], 404);
            }

            $data->delete();

            return response()->json([
                "status" => true,
                "message" => "Successfully deleted the Diskusi!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Failed to delete the Diskusi!!!",
                "data" => $e->getMessage()
            ], 400);
        }
    }
}
