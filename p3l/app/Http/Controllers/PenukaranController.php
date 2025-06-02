<?php

namespace App\Http\Controllers;

use App\Models\Penukaran;
use Illuminate\Http\Request;

class PenukaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = Penukaran::all();

            return response()->json([
                "status" => true,
                "message" => "Getting all Penukaran successful!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Getting all Penukaran failed!!!",
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
            // Validate incoming request data, exclude ID_ORGANISASI as it will be generated
            $validateData = $request->validate([
                'NAMA_ORGANISASI' => 'required|string|max:255', // NOT NULL
                'PASSWORD_ORGANISASI' => 'required|string|min:8', // NOT NULL, added min length
                'NOTELP_ORGANISASI' => 'required|string', // NOT NULL
                'ALAMAT_ORGANISASI' => 'required|string', // NOT NULL
                'EMAIL_ORGANISASI' => 'required|string|email|max:255|unique:organisasi,EMAIL_ORGANISASI', // NOT NULL, added email format and uniqueness
            ]);

            // Generate unique ID_ORGANISASI (e.g., ORG001, ORG002, ...)
            // Find the last Organisasi record to get the highest ID number
            $lastOrganisasi = Organisasi::orderBy('ID_ORGANISASI', 'desc')->first();

            // Extract the numeric part from the last ID, or start with 0 if no records exist
            // Assumes ID format is ORG + 3 digits
            $lastIdNumber = $lastOrganisasi ? (int) substr($lastOrganisasi->ID_ORGANISASI, 3) : 0;

            // Increment the number for the new ID
            $nextIdNumber = $lastIdNumber + 1;

            // Format the new ID with the prefix 'ORG' and pad with leading zeros to 3 digits
            $generatedId = 'ORG' . str_pad($nextIdNumber, 3, '0', STR_PAD_LEFT);

            // Create a new Organisasi instance and set the generated ID and other data
            $organisasi = new Organisasi($validateData); // Fill other attributes using mass assignment
            $organisasi->ID_ORGANISASI = $generatedId; // Manually set the generated primary key
            $organisasi->PASSWORD_ORGANISASI = Hash::make($request->PASSWORD_ORGANISASI); // Hash and set password
            $organisasi->save(); // Save the model to the database

            // You might want to hide the password in the response
            // $organisasi->makeHidden('PASSWORD_ORGANISASI');


            return response()->json([
                "status" => true,
                "message" => "Organisasi successfully created/registered!",
                "data" => $organisasi,
            ], 201); // Use 201
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Failed at creating/registering the Organisasi!",
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
            $data = Penukaran::find($id);

            if (!$data) {
                return response()->json(['message' => 'Penukaran ID not found!!!'], 404);
            }

            return response()->json([
                "status" => true,
                "message" => "Getting the selected Penukaran successful!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Getting the selected Penukaran failed!!!",
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
            $data = Penukaran::find($id);

            if (!$data) {
                return response()->json(['message' => 'Penukaran ID not found!!!'], 404);
            }

             $validateData = $request->validate([
                'ID_PEMBELI' => 'required|string',
                'NAMA_PENUKAR' => 'required|string',
                'TANGGAL_TUKAR' => 'required|date',
            ]);

            $data->update($validateData);

            return response()->json([
                "status" => true,
                "message" => "Penukaran successfully updated!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Failed at updating the Penukaran!!!",
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
            $data = Penukaran::find($id);

            if (!$data) {
                return response()->json(['message' => 'Penukaran ID not found!!!'], 404);
            }

            // Consider deleting related Merchandise if Merchandise cannot exist without Penukaran
            // Note: Merchandise hasOne Penukaran, so deleting Penukaran might require deleting
            // the associated Merchandise record first, or setting up cascade deletes.
            if ($data->merchandise()->exists()) {
                 $data->merchandise->delete(); // Example: Cascade delete Merchandise
             }

            $data->delete();

            return response()->json([
                "status" => true,
                "message" => "Successfully deleted the Penukaran!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Failed to delete the Penukaran!!!",
                "data" => $e->getMessage()
            ], 400);
        }
    }
}