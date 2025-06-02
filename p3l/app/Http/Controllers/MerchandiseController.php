<?php

namespace App\Http\Controllers;

use App\Models\Merchandise;
use Illuminate\Http\Request;

class MerchandiseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = Merchandise::all();

            return response()->json([
                "status" => true,
                "message" => "Getting all Merchandise successful!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Getting all Merchandise failed!!!",
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
            // Validate incoming request data, exclude ID_MERCHANDISE as it will be generated
            $validateData = $request->validate([
                'NAMA_MERCHANDISE' => 'required|string', // NOT NULL in DB
                'ID_PENUKARAN' => 'required|string', // NOT NULL in DB
            ]);

            // Generate unique ID_MERCHANDISE (e.g., MCH001, MCH002, ...)
            // Find the last Merchandise record to get the highest ID number
            $lastMerchandise = Merchandise::orderBy('ID_MERCHANDISE', 'desc')->first();

            // Extract the numeric part from the last ID, or start with 0 if no records exist
            // Assumes ID format is MCH + 3 digits
            $lastIdNumber = $lastMerchandise ? (int) substr($lastMerchandise->ID_MERCHANDISE, 3) : 0;

            // Increment the number for the new ID
            $nextIdNumber = $lastIdNumber + 1;

            // Format the new ID with the prefix 'MCH' and pad with leading zeros to 3 digits
            $generatedId = 'MCH' . str_pad($nextIdNumber, 3, '0', STR_PAD_LEFT);

            // Create a new Merchandise instance and set the generated ID and other data
            $merchandise = new Merchandise($validateData); // Fill other attributes using mass assignment
            $merchandise->ID_MERCHANDISE = $generatedId; // Manually set the generated primary key
            $merchandise->save(); // Save the model to the database


            return response()->json([
                "status" => true,
                "message" => "Merchandise successfully created!",
                "data" => $merchandise,
            ], 201); // Use 201
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Failed at creating the Merchandise!",
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
            $data = Merchandise::find($id);

            if (!$data) {
                return response()->json(['message' => 'Merchandise ID not found!!!'], 404);
            }

            return response()->json([
                "status" => true,
                "message" => "Getting the selected Merchandise successful!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Getting the selected Merchandise failed!!!",
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
            $data = Merchandise::find($id);

            if (!$data) {
                return response()->json(['message' => 'Merchandise ID not found!!!'], 404);
            }

            $validateData = $request->validate([
                'NAMA_MERCHANDISE' => 'required|string',
                'ID_PENUKARAN' => 'required|string',
            ]);

            $data->update($validateData);

            return response()->json([
                "status" => true,
                "message" => "Merchandise successfully updated!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Failed at updating the Merchandise!!!",
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
            $data = Merchandise::find($id);

            if (!$data) {
                return response()->json(['message' => 'Merchandise ID not found!!!'], 404);
            }

            // Consider checking for related records in 'penukaran' before deleting
             if ($data->penukaran()->exists()) {
                 // Note: Penukaran hasOne merchandise, so maybe this check isn't strictly needed
                 // if deleting Merchandise should cascade or is acceptable when Penukaran exists.
                 // However, if you want to prevent orphaned Penukaran records, check here.
                 // This model has BelongsTo Penukaran, meaning Penukaran is the parent.
                 // So deleting Merchandise should be fine unless Penukaran must always have Merch.
             }

            $data->delete();

            return response()->json([
                "status" => true,
                "message" => "Successfully deleted the Merchandise!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Failed to delete the Merchandise!!!",
                "data" => $e->getMessage()
            ], 400);
        }
    }
}