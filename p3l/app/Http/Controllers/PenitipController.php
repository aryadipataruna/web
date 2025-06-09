<?php

namespace App\Http\Controllers;

use App\Models\Penitip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; // Import Auth facade

class PenitipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = Penitip::all();

            return response()->json([
                "status" => true,
                "message" => "Getting all Penitip successful!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Getting all Penitip failed!!!",
                "data" => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     * This method is also used for registration.
     */
    public function store(Request $request)
    {
        try {
            // Validate incoming request data, exclude ID_PENITIP as it will be generated
            $validateData = $request->validate([
                'NAMA_PENITIP' => 'required|string|max:255', // NOT NULL
                'ALAMAT_PENITIP' => 'required|string', // NOT NULL
                'EMAIL_PENITIP' => 'required|string|email|max:255|unique:PENITIP,EMAIL_PENITIP',
                'PASSWORD_PENITIP' => 'required|string|min:8', // NOT NULL, added min length
                'SALDO_PENITIP' => 'required|numeric', // NOT NULL
                'POIN_PENITIP' => 'required|numeric', // NOT NULL
            ]);

            // Generate unique ID_PENITIP (e.g., PEN001, PEN002, ...)
            // Find the last Penitip record to get the highest ID number
            $lastPenitip = Penitip::orderBy('ID_PENITIP', 'desc')->first();

            // Extract the numeric part from the last ID.
            // Note: Existing data uses 'PENT', but requested format is 'PEN'.
            // We'll extract from 'PENT' for continuity with existing data,
            // but generate 'PEN' IDs as requested.
            $lastIdNumber = $lastPenitip ? (int) substr($lastPenitip->ID_PENITIP, 4) : 0; // Extract after 'PENT'

            // Increment the number for the new ID
            $nextIdNumber = $lastIdNumber + 1;

            // Format the new ID with the prefix 'PEN' and pad with leading zeros to 3 digits
            $generatedId = 'PEN' . str_pad($nextIdNumber, 3, '0', STR_PAD_LEFT);

            // Create a new Penitip instance and set the generated ID and other data
            $penitip = new Penitip($validateData); // Fill other attributes using mass assignment
            $penitip->ID_PENITIP = $generatedId; // Manually set the generated primary key
            $penitip->PASSWORD_PENITIP = Hash::make($request->PASSWORD_PENITIP); // Hash and set password
            $penitip->save(); // Save the model to the database

             // You might want to hide the password in the response
            // $penitip->makeHidden('PASSWORD_PENITIP');

            return response()->json([
                "status" => true,
                "message" => "Penitip successfully created/registered!",
                "data" => $penitip,
            ], 201); // Use 201
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Failed at creating/registering the Penitip!",
                "data" => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Handle user login.
     */
    public function login(Request $request)
    {
        $request->validate([
            // Assuming login uses ID_PENITIP or another unique identifier like email if it existed
            // Using ID_PENITIP for now based on schema
            'ID_PENITIP' => 'required|string',
            'PASSWORD_PENITIP' => 'required|string',
        ]);

        // Find the user by ID_PENITIP
        $user = Penitip::where('ID_PENITIP', $request->ID_PENITIP)->first();

        // Check if user exists and password is correct
        if (!$user || !Hash::check($request->PASSWORD_PENITIP, $user->PASSWORD_PENITIP)) {
            return response()->json(['message' => 'Invalid credentials!!!'], 401);
        }

        // Generate a new API token for the user
        $token = $user->createToken('Penitip Access Token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'message' => 'Login Successful!'
        ], 200);
    }

    /**
     * Handle user logout.
     */
    public function logout(Request $request)
    {
         // Ensure the user is authenticated via API token
        if (Auth::guard('api')->check()) {
            // Delete the current API token
            $request->user('api')->currentAccessToken()->delete();
            return response()->json(['message' => 'Logged out successfully!']);
        }

        return response()->json(['message' => 'Not logged in or invalid token!!!'], 401);
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $data = Penitip::find($id);

            if (!$data) {
                return response()->json(['message' => 'Penitip ID not found!!!'], 404);
            }

             // Hide password in the response
            // $data->makeHidden('PASSWORD_PENITIP');

            return response()->json([
                "status" => true,
                "message" => "Getting the selected Penitip successful!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Getting the selected Penitip failed!!!",
                "data" => $e->getMessage()
            ], 400);
        }
    }

    public function showbyName($id)
    {
        try {
            $data = Penitip::find($id);

            if (!$data) {
                return response()->json(['message' => 'Penitip ID not found!!!'], 404);
            }

             // Hide password in the response
            // $data->makeHidden('PASSWORD_PENITIP');

            return response()->json([
                "status" => true,
                "message" => "Getting the selected Penitip successful!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Getting the selected Penitip failed!!!",
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
            $data = Penitip::find($id);

            if (!$data) {
                return response()->json(['message' => 'Penitip ID not found!!!'], 404);
            }

            $validateData = $request->validate([
                'NAMA_PENITIP' => 'required|string',
                'ALAMAT_PENITIP' => 'required|string',
                'EMAIL_PENITIP' => 'required|string|email|unique:organisasi,EMAIL_PENITIP,' . $id . ',ID_PENITIP',
                'PASSWORD_PENITIP' => 'nullable|string|min:8', // Make password nullable for update
                'SALDO_PENITIP' => 'required|numeric',
                'POIN_PENITIP' => 'required|numeric',
            ]);

            // Hash password if provided in the update request
             if (isset($validateData['PASSWORD_PENITIP'])) {
                 $validateData['PASSWORD_PENITIP'] = Hash::make($request->PASSWORD_PENITIP);
             } else {
                 // Remove password from $validateData if not provided, so it's not updated to null
                 unset($validateData['PASSWORD_PENITIP']);
             }


            $data->update($validateData);

            // Hide password in the response
            // $data->makeHidden('PASSWORD_PENITIP');


            return response()->json([
                "status" => true,
                "message" => "Penitip successfully updated!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Failed at updating the Penitip!!!",
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
            $data = Penitip::find($id);

            if (!$data) {
                return response()->json(['message' => 'Penitip ID not found!!!'], 404);
            }

            // Consider checking for related records in 'barang', 'diskusi' before deleting
             if ($data->barang()->exists() || $data->diskusi()->exists()) {
                 return response()->json([
                    "status" => false,
                    "message" => "Cannot delete Penitip because it is linked to Barang or Diskusi records.",
                    "data" => null
                ], 409); // Conflict
             }


            $data->delete();

            return response()->json([
                "status" => true,
                "message" => "Successfully deleted the Penitip!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Failed to delete the Penitip!!!",
                "data" => $e->getMessage()
            ], 400);
        }
    }

    public function showPenitipRating($id)
    {
        // Temukan barang berdasarkan ID
        $penitip = Penitip::find($id);

        // Jika barang tidak ditemukan
        if (!$$penitip) {
            return response()->json([
                'success' => false,
                'message' => 'Penitip tidak ditemukan.'
            ], 404);
        }

        // Ambil rating dari relasi di model Barang (hasOne)
        $ratingData = $penitip->rating;

        // Jika tidak ada rating yang ditemukan untuk barang ini di tabel 'ratings'
        if (!$ratingData) {
            return response()->json([
                'success' => true,
                'message' => 'Barang ini belum memiliki rating.',
                'rating'  => null // Mengembalikan null jika belum ada rating
            ], 200);
        }

        // Jika rating ditemukan
        return response()->json([
            'success' => true,
            'message' => 'Rating barang ditemukan.',
            'rating'  => $penitip->rating 
        ]);
    }

    public function getAllPenitipsForDisplay()
    {
        try {
            $penitip = Penitip::all(); // Or Penitip::select('ID_PENITIP', 'NAMA_PENITIP', 'ALAMAT_PENITIP', 'RATING')->get();

            // If you need to attach calculated ratings (from ratings table) or review counts
            // that are NOT in the 'RATING' column directly, you'd do it here.
            // But based on our previous discussion, we're using the 'RATING' column.
            $data = $penitip->map(function($penitip) {
                return [
                    'ID_PENITIP' => $penitip->ID_PENITIP,
                    'NAMA_PENITIP' => $penitip->NAMA_PENITIP,
                    'ALAMAT_PENITIP' => $penitip->ALAMAT_PENITIP,
                    'RATING' => $penitip->RATING,
                ];
            });

            return response()->json($data);

        } catch (\Exception $e) {
            Log::error("Error fetching public penitip data: " . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'message' => 'Failed to fetch public penitip data.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
