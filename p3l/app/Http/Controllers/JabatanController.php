<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = Jabatan::all();

            return response()->json([
                "status" => true,
                "message" => "Getting all Jabatan successful!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Getting all Jabatan failed!!!",
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
            // Validate incoming request data, exclude ID_JABATAN as it will be generated
            $validateData = $request->validate([
                'NAMA_JABATAN' => 'required|string', // NOT NULL in DB
            ]);

            // Generate unique ID_JABATAN (e.g., JAB001, JAB002, ...)
            // Find the last Jabatan record to get the highest ID number
            $lastJabatan = Jabatan::orderBy('ID_JABATAN', 'desc')->first();

            // Extract the numeric part from the last ID, or start with 0 if no records exist
            // Assumes ID format is JAB + 3 digits
            $lastIdNumber = $lastJabatan ? (int) substr($lastJabatan->ID_JABATAN, 3) : 0;

            // Increment the number for the new ID
            $nextIdNumber = $lastIdNumber + 1;

            // Format the new ID with the prefix 'JAB' and pad with leading zeros to 3 digits
            $generatedId = 'JAB' . str_pad($nextIdNumber, 3, '0', STR_PAD_LEFT);

            // Create a new Jabatan instance and set the generated ID and other data
            $jabatan = new Jabatan($validateData); // Fill other attributes using mass assignment
            $jabatan->ID_JABATAN = $generatedId; // Manually set the generated primary key
            $jabatan->save(); // Save the model to the database


            return response()->json([
                "status" => true,
                "message" => "Jabatan successfully created!",
                "data" => $jabatan,
            ], 201); // Use 201
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Failed at creating the Jabatan!",
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
            $data = Jabatan::find($id);

            if (!$data) {
                return response()->json(['message' => 'Jabatan ID not found!!!'], 404);
            }

            return response()->json([
                "status" => true,
                "message" => "Getting the selected Jabatan successful!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Getting the selected Jabatan failed!!!",
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
            $data = Jabatan::find($id);

            if (!$data) {
                return response()->json(['message' => 'Jabatan ID not found!!!'], 404);
            }

            $validateData = $request->validate([
                'NAMA_JABATAN' => 'required|string',
            ]);

            $data->update($validateData);

            return response()->json([
                "status" => true,
                "message" => "Jabatan successfully updated!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Failed at updating the Jabatan!!!",
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
            $data = Jabatan::find($id);

            if (!$data) {
                return response()->json(['message' => 'Jabatan ID not found!!!'], 404);
            }

            // Consider checking for related records in 'pegawai' before deleting
            if ($data->pegawai()->exists()) {
                 return response()->json([
                    "status" => false,
                    "message" => "Cannot delete Jabatan because it is linked to Pegawai records.",
                    "data" => null
                ], 409); // Conflict
            }


            $data->delete();

            return response()->json([
                "status" => true,
                "message" => "Successfully deleted the Jabatan!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Failed to delete the Jabatan!!!",
                "data" => $e->getMessage()
            ], 400);
        }
    }
}