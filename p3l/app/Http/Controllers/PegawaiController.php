<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; // Import Auth facade
use Illuminate\Support\Str; // Import Str facade for string manipulation

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = Pegawai::all();

            return response()->json([
                "status" => true,
                "message" => "Getting all Pegawai successful!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Getting all Pegawai failed!!!",
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
            // Validate incoming request data, exclude ID_PEGAWAI as it will be generated
            $validateData = $request->validate([
                'ID_JABATAN' => 'required|string', // NOT NULL
                'NAMA_PEGAWAI' => 'required|string|max:255', // NOT NULL
                'TGL_LAHIR_PEGAWAI' => 'required|string', // NOT NULL, stored as varchar in DB, consider 'date' or 'date_format' if possible
                'NOTELP_PEGAWAI' => 'required|string', // NOT NULL
                'EMAIL_PEGAWAI' => 'required|string|email|max:255|unique:pegawai,EMAIL_PEGAWAI', // NOT NULL, added email format and uniqueness
                'PASSWORD_PEGAWAI' => 'required|string|min:8', // NOT NULL, added min length
                'ALAMAT_PEGAWAI' => 'required|string', // NOT NULL
            ]);

             // Generate unique ID_PEGAWAI (e.g., PEG001, PEG002, ...)
            $lastPegawai = Pegawai::orderBy('ID_PEGAWAI', 'desc')->first();
            // Extract numeric part after 'PEG' (3 characters)
            $nextIdNumber = $lastPegawai ? (int) substr($lastPegawai->ID_PEGAWAI, 3) + 1 : 1;
            $generatedId = 'PEG' . str_pad($nextIdNumber, 3, '0', STR_PAD_LEFT);

            // Add the generated ID and hashed password to the data array
            $validateData['ID_PEGAWAI'] = $generatedId;
            $validateData['PASSWORD_PEGAWAI'] = Hash::make($request->PASSWORD_PEGAWAI);

            // Create the new Pegawai record
            $data = Pegawai::create($validateData);

             // You might want to hide the password in the response
            // $data->makeHidden('PASSWORD_PEGAWAI');

            return response()->json([
                "status" => true,
                "message" => "Pegawai successfully created/registered!",
                "data" => $data,
            ], 201); // Use 201
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Failed at creating/registering the Pegawai!",
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
            'EMAIL_PEGAWAI' => 'required|string|email',
            'PASSWORD_PEGAWAI' => 'required|string',
        ]);

        // Find the user by email
        $user = Pegawai::where('EMAIL_PEGAWAI', $request->EMAIL_PEGAWAI)->first();

        // Check if user exists and password is correct
        if (!$user || !Hash::check($request->PASSWORD_PEGAWAI, $user->PASSWORD_PEGAWAI)) {
            return response()->json(['message' => 'Invalid credentials!!!'], 401);
        }

        // Generate a new API token for the user
        $token = $user->createToken('Pegawai Access Token')->plainTextToken;

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
            $data = Pegawai::find($id);

            if (!$data) {
                return response()->json(['message' => 'Pegawai ID not found!!!'], 404);
            }

             // Hide password in the response
            // $data->makeHidden('PASSWORD_PEGAWAI');

            return response()->json([
                "status" => true,
                "message" => "Getting the selected Pegawai successful!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Getting the selected Pegawai failed!!!",
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
            $data = Pegawai::find($id);

            if (!$data) {
                return response()->json(['message' => 'Pegawai ID not found!!!'], 404);
            }

             // Adjust validation for unique email during update
            $validateData = $request->validate([
                'ID_JABATAN' => 'required|string',
                'NAMA_PEGAWAI' => 'required|string',
                'TGL_LAHIR_PEGAWAI' => 'required|string',
                'NOTELP_PEGAWAI' => 'required|string',
                'EMAIL_PEGAWAI' => 'required|string|email|unique:pegawai,EMAIL_PEGAWAI,' . $id . ',ID_PEGAWAI', // Ignore current ID
                'PASSWORD_PEGAWAI' => 'nullable|string|min:8', // Make password nullable for update, **HASH THIS IN PRODUCTION IF PROVIDED**
                'ALAMAT_PEGAWAI' => 'required|string',
            ]);

             // Hash password if provided in the update request
             if (isset($validateData['PASSWORD_PEGAWAI'])) {
                 $validateData['PASSWORD_PEGAWAI'] = Hash::make($request->PASSWORD_PEGAWAI);
             } else {
                 // Remove password from $validateData if not provided, so it's not updated to null
                 unset($validateData['PASSWORD_PEGAWAI']);
             }


            $data->update($validateData);

            // Hide password in the response
            // $data->makeHidden('PASSWORD_PEGAWAI');

            return response()->json([
                "status" => true,
                "message" => "Pegawai successfully updated!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Failed at updating the Pegawai!!!",
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
            $data = Pegawai::find($id);

            if (!$data) {
                return response()->json(['message' => 'Pegawai ID not found!!!'], 404);
            }

            // Consider checking for related records in 'barang', 'komisi', 'penjualan' before deleting
             if ($data->barangDitangani()->exists() || $data->komisiDiterima()->exists() || $data->penjualanDilakukan()->exists()) {
                 return response()->json([
                    "status" => false,
                    "message" => "Cannot delete Pegawai because it is linked to Barang, Komisi, or Penjualan records.",
                    "data" => null
                ], 409); // Conflict
             }


            $data->delete();

            return response()->json([
                "status" => true,
                "message" => "Successfully deleted the Pegawai!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Failed to delete the Pegawai!!!",
                "data" => $e->getMessage()
            ], 400);
        }
    }
}
