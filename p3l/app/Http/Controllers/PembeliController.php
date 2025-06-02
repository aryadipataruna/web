<?php

namespace App\Http\Controllers;

use App\Models\Pembeli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; // Import Auth facade
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; // Import Str facade for string manipulation

class PembeliController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = Pembeli::all();

            return response()->json([
                "status" => true,
                "message" => "Getting all Pembeli successful!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Getting all Pembeli failed!!!",
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
            // Validate incoming request data, exclude ID_PEMBELI as it will be generated
            $validateData = $request->validate([
                'NAMA_PEMBELI' => 'required|string|max:255', // NOT NULL
                'EMAIL_PEMBELI' => 'required|string|email|max:255|unique:pembeli,EMAIL_PEMBELI', // NOT NULL, added email format and uniqueness
                'PASSWORD_PEMBELI' => 'required|string|min:8', // NOT NULL, added min length
                'NO_PEMBELI' => 'required|string', // NOT NULL
                'ALAMAT_PEMBELI' => 'required|string', // NOT NULL
                'POIN_PEMBELI' => 'nullable|numeric', // NULLABLE
            ]);

            // Generate unique ID_PEMBELI (e.g., PEM001, PEM002, ...)
            // Find the last Pembeli record to get the highest ID number
            $lastPembeli = Pembeli::orderBy('ID_PEMBELI', 'desc')->first();

            // Extract the numeric part from the last ID, or start with 0 if no records exist
            $lastIdNumber = $lastPembeli ? (int) substr($lastPembeli->ID_PEMBELI, 3) : 0;

            // Increment the number for the new ID
            $nextIdNumber = $lastIdNumber + 1;

            // Format the new ID with the prefix 'PEM' and pad with leading zeros to 3 digits
            $generatedId = 'PEM' . str_pad($nextIdNumber, 3, '0', STR_PAD_LEFT);

            // Create a new Pembeli instance and set the generated ID and other data
            $pembeli = new Pembeli($validateData); // Fill other attributes using mass assignment
            $pembeli->ID_PEMBELI = $generatedId; // Manually set the generated primary key
            $pembeli->PASSWORD_PEMBELI = Hash::make($request->PASSWORD_PEMBELI); // Hash and set password
            $pembeli->save(); // Save the model to the database

            // You might want to hide the password in the response
            // $pembeli->makeHidden('PASSWORD_PEMBELI');

            // return response()->json([
            //     "status" => true,
            //     "message" => "Pembeli successfully created/registered!",
            //     "data" => $pembeli,
            // ], 201); // Use 201 for created resource
            return redirect()->route('login-regis')->with('success', 'Pendaftaran Pembeli berhasil! Silakan masuk.');

        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Failed at creating/registering the Pembeli!",
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
            'EMAIL_PEMBELI' => 'required|string|email',
            'PASSWORD_PEMBELI' => 'required|string',
        ]);

        // Find the user by email
        $user = Pembeli::where('EMAIL_PEMBELI', $request->EMAIL_PEMBELI)->first();

        // Check if user exists and password is correct
        if (!$user || !Hash::check($request->PASSWORD_PEMBELI, $user->PASSWORD_PEMBELI)) {
            return response()->json(['message' => 'Invalid credentials!!!'], 401);
        }

        // Generate a new API token for the user
        $token = $user->createToken('Pembeli Access Token')->plainTextToken;

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
            $data = Pembeli::find($id);

            if (!$data) {
                return response()->json(['message' => 'Pembeli ID not found!!!'], 404); // Use 404
            }

             // Hide password in the response
            // $data->makeHidden('PASSWORD_PEMBELI');

            return response()->json([
                "status" => true,
                "message" => "Getting the selected Pembeli successful!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Getting the selected Pembeli failed!!!",
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
            $data = Pembeli::find($id);

            if (!$data) {
                return response()->json(['message' => 'Pembeli ID not found!!!'], 404);
            }

             // Adjust validation for unique email during update
            $validateData = $request->validate([
                'NAMA_PEMBELI' => 'required|string',
                'PASSWORD_PEMBELI' => 'nullable|string|min:8', // Make password nullable for update, **HASH THIS IN PRODUCTION IF PROVIDED**
                'NO_PEMBELI' => 'required|string',
                'ALAMAT_PEMBELI' => 'required|string',
            ]);

             // Hash password if provided in the update request
             if (isset($validateData['PASSWORD_PEMBELI'])) {
                 $validateData['PASSWORD_PEMBELI'] = Hash::make($request->PASSWORD_PEMBELI);
             } else {
                 // Remove password from $validateData if not provided, so it's not updated to null
                 unset($validateData['PASSWORD_PEMBELI']);
             }

            $data->update($validateData);

            // Hide password in the response
            // $data->makeHidden('PASSWORD_PEMBELI');

            return response()->json([
                "status" => true,
                "message" => "Pembeli successfully updated!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Failed at updating the Pembeli!!!",
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
            $data = Pembeli::find($id);

            if (!$data) {
                return response()->json(['message' => 'Pembeli ID not found!!!'], 404);
            }

            // Consider checking for related records in 'alamat', 'diskusi', 'penjualan', 'penukaran' before deleting
             if ($data->alamat()->exists() || $data->diskusi()->exists() || $data->penjualan()->exists() || $data->penukaran()->exists()) {
                 return response()->json([
                    "status" => false,
                    "message" => "Cannot delete Pembeli because it is linked to Alamat, Diskusi, Penjualan, or Penukaran records.",
                    "data" => null
                ], 409); // Conflict
             }

            $data->delete();

            return response()->json([
                "status" => true,
                "message" => "Successfully deleted the Pembeli!",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Failed to delete the Pembeli!!!",
                "data" => $e->getMessage()
            ], 400);
        }
    }
}
