<?php

namespace App\Http\Controllers;

use App\Models\Organisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; // Import Auth facade

class OrganisasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = Organisasi::all();

            return response()->json([
                "status" => true,
                "message" => "Getting all Organisasi successful!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Getting all Organisasi failed!!!",
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
     * Handle user login.
     */
    public function login(Request $request)
    {
        $request->validate([
            'EMAIL_ORGANISASI' => 'required|string|email',
            'PASSWORD_ORGANISASI' => 'required|string',
        ]);

        // Find the user by email
        $user = Organisasi::where('EMAIL_ORGANISASI', $request->EMAIL_ORGANISASI)->first();

        // Check if user exists and password is correct
        if (!$user || !Hash::check($request->PASSWORD_ORGANISASI, $user->PASSWORD_ORGANISASI)) {
            return response()->json(['message' => 'Invalid credentials!!!'], 401);
        }

        // Generate a new API token for the user
        $token = $user->createToken('Organisasi Access Token')->plainTextToken;

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
            $data = Organisasi::find($id);

            if (!$data) {
                return response()->json(['message' => 'Organisasi ID not found!!!'], 404);
            }

            // Hide password in the response
            // $data->makeHidden('PASSWORD_ORGANISASI');

            return response()->json([
                "status" => true,
                "message" => "Getting the selected Organisasi successful!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Getting the selected Organisasi failed!!!",
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
            $data = Organisasi::find($id);

            if (!$data) {
                return response()->json(['message' => 'Organisasi ID not found!!!'], 404);
            }

             // Adjust validation for unique email during update
            $validateData = $request->validate([
                'NAMA_ORGANISASI' => 'required|string',
                'PASSWORD_ORGANISASI' => 'nullable|string|min:8', // Make password nullable for update
                'NOTELP_ORGANISASI' => 'required|string',
                'ALAMAT_ORGANISASI' => 'required|string',
                'EMAIL_ORGANISASI' => 'required|string|email|unique:organisasi,EMAIL_ORGANISASI,' . $id . ',ID_ORGANISASI', // Ignore current ID
            ]);

             // Hash password if provided in the update request
             if (isset($validateData['PASSWORD_ORGANISASI'])) {
                 $validateData['PASSWORD_ORGANISASI'] = Hash::make($request->PASSWORD_ORGANISASI);
             } else {
                 // Remove password from $validateData if not provided, so it's not updated to null
                 unset($validateData['PASSWORD_ORGANISASI']);
             }


            $data->update($validateData);

            // Hide password in the response
            // $data->makeHidden('PASSWORD_ORGANISASI');

            return response()->json([
                "status" => true,
                "message" => "Organisasi successfully updated!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Failed at updating the Organisasi!!!",
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
            $data = Organisasi::find($id);

            if (!$data) {
                return response()->json(['message' => 'Organisasi ID not found!!!'], 404);
            }

            // Consider checking for related records in 'alamat', 'donasi', 'reqdonasi' before deleting
             if ($data->alamat()->exists() || $data->donasi()->exists() || $data->reqDonasi()->exists()) {
                 return response()->json([
                    "status" => false,
                    "message" => "Cannot delete Organisasi because it is linked to Alamat, Donasi, or ReqDonasi records.",
                    "data" => null
                ], 409); // Conflict
             }


            $data->delete();

            return response()->json([
                "status" => true,
                "message" => "Successfully deleted the Organisasi!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Failed to delete the Organisasi!!!",
                "data" => $e->getMessage()
            ], 400);
        }
    }
}
