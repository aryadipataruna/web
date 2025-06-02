<?php

namespace App\Http\Controllers;

use App\Models\ReqDonasi;
use Illuminate\Http\Request;

class ReqDonasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = ReqDonasi::all();

            return response()->json([
                "status" => true,
                "message" => "Getting all ReqDonasi successful!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Getting all ReqDonasi failed!!!",
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
            // Validate incoming request data, exclude ID_REQDONASI as it will be generated
            $validateData = $request->validate([
                'ID_ORGANISASI' => 'required|string', // NOT NULL
                'NAMA_BARANG_REQDONASI' => 'required|string', // NOT NULL
                'TGL_REQ' => 'required|date', // NOT NULL
            ]);

            // Generate unique ID_REQDONASI (e.g., REQ001, REQ002, ...)
            // Find the last ReqDonasi record to get the highest ID number
            $lastReqDonasi = ReqDonasi::orderBy('ID_REQDONASI', 'desc')->first();

            // Extract the numeric part from the last ID, or start with 0 if no records exist
            // Assumes ID format is REQ + 3 digits
            $lastIdNumber = $lastReqDonasi ? (int) substr($lastReqDonasi->ID_REQDONASI, 3) : 0;

            // Increment the number for the new ID
            $nextIdNumber = $lastIdNumber + 1;

            // Format the new ID with the prefix 'REQ' and pad with leading zeros to 3 digits
            $generatedId = 'REQ' . str_pad($nextIdNumber, 3, '0', STR_PAD_LEFT);

            // Create a new ReqDonasi instance and set the generated ID and other data
            $reqDonasi = new ReqDonasi($validateData); // Fill other attributes using mass assignment
            $reqDonasi->ID_REQDONASI = $generatedId; // Manually set the generated primary key
            $reqDonasi->save(); // Save the model to the database


            return response()->json([
                "status" => true,
                "message" => "ReqDonasi successfully created!",
                "data" => $reqDonasi,
            ], 201); // Use 201
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Failed at creating the ReqDonasi!",
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
            $data = ReqDonasi::find($id);

            if (!$data) {
                return response()->json(['message' => 'ReqDonasi ID not found!!!'], 404);
            }

            return response()->json([
                "status" => true,
                "message" => "Getting the selected ReqDonasi successful!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Getting the selected ReqDonasi failed!!!",
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
            $data = ReqDonasi::find($id);

            if (!$data) {
                return response()->json(['message' => 'ReqDonasi ID not found!!!'], 404);
            }

             $validateData = $request->validate([
                'ID_ORGANISASI' => 'required|string',
                'NAMA_BARANG_REQDONASI' => 'required|string',
                'TGL_REQ' => 'required|date',
            ]);


            $data->update($validateData);

            return response()->json([
                "status" => true,
                "message" => "ReqDonasi successfully updated!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Failed at updating the ReqDonasi!!!",
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
            $data = ReqDonasi::find($id);

            if (!$data) {
                return response()->json(['message' => 'ReqDonasi ID not found!!!'], 404);
            }

            // Consider checking for related records in 'organisasi' (parent) before deleting
            // Although it's a BelongsTo, deleting the child should be fine unless Organisasi
            // must always have associated requests.

            $data->delete();

            return response()->json([
                "status" => true,
                "message" => "Successfully deleted the ReqDonasi!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Failed to delete the ReqDonasi!!!",
                "data" => $e->getMessage()
            ], 400);
        }
    }
}