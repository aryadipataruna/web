<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Pembeli;
use App\Models\Penitip;
use App\Models\Organisasi;
use App\Models\Jabatan; // Import Jabatan model for getPegawaiRole

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; // Import Auth facade for logout
use Laravel\Sanctum\PersonalAccessToken; // Import PersonalAccessToken if needed, though not strictly necessary for this code

class LoginController extends Controller
{
    /**
     * Handle user login.
     */
    public function login(Request $request)
    {
        // Validate incoming login request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'remember' => 'boolean' // Optional remember Me functionality
        ]);

        $email = $request->email;
        $password = $request->password;
        $remember = $request->remember ?? false; // Default remember to false

        // Attempt to get user information by email from different models
        $userInfo = $this->getUserInfoByEmail($email);

        // Check if user was found
        if (!$userInfo) {
            return response()->json([
                'success' => false,
                'message' => 'Email tidak terdaftar' // Email not registered
            ], 401); // Use 401 Unauthorized for login failures
        }

        // Check if the provided password matches the hashed password in the database
        if (!Hash::check($password, $userInfo['password'])) {
            return response()->json([
                'success' => false,
                'message' => 'Password salah' // Incorrect password
            ], 401); // Use 401 Unauthorized
        }

        // If login is successful, create a new API token
        $token = $this->createTokenForUser($userInfo['model'], $userInfo['role']);

        // return redirect()->route('home')->with('success', 'Login berhasil! Selamat datang.');
        // Return a successful login response
        return response()->json([
            'success' => true,
            'data' => [
                'token' => $token,
                'user' => $userInfo['model'], // Return the user model data
                'role' => $userInfo['role'] // Return the determined role
            ],
            'message' => 'Login berhasil' // Login successful
        ]);
    }

    /**
     * Get the authenticated user's information.
     * Requires 'auth:sanctum' middleware on the route.
     */
    public function getUser(Request $request)
    {
        // $request->user() will return the authenticated user model instance
        $user = $request->user();

        // If no user is authenticated, return unauthorized
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated' // User not authenticated
            ], 401);
        }

        // Determine the role based on the user model type or abilities
        $role = $this->getRoleFromToken($user); // Get role from token abilities

        // Return authenticated user data and role
        return response()->json([
            'success' => true,
            'data' => [
                'user' => $user,
                'role' => $role
            ],
            'message' => 'Authenticated user data retrieved successfully' // Success message
        ]);
    }

    /**
     * Attempt to find a user by email across different models.
     * Returns an array with model, role, and password if found, otherwise null.
     */
    private function getUserInfoByEmail($email)
    {
        // Check Pegawai table using EMAIL_PEGAWAI column
        $pegawai = Pegawai::where('EMAIL_PEGAWAI', $email)->first();
        if ($pegawai) {
            $role = $this->getPegawaiRole($pegawai->ID_JABATAN); // Use ID_JABATAN column
            return [
                'model' => $pegawai,
                'role' => $role,
                'password' => $pegawai->PASSWORD_PEGAWAI // Use PASSWORD_PEGAWAI column
            ];
        }

        // Check Penitip table using EMAIL_PENITIP column
        // Corrected column name to EMAIL_PENITIP (all caps)
        $penitip = Penitip::where('EMAIL_PENITIP', $email)->first();
        if ($penitip) {
            return [
                'model' => $penitip,
                'role' => 'penitip',
                'password' => $penitip->PASSWORD_PENITIP // Use PASSWORD_PENITIP column
            ];
        }

        // Check Pembeli table using EMAIL_PEMBELI column
        $pembeli = Pembeli::where('EMAIL_PEMBELI', $email)->first();
        if ($pembeli) {
            return [
                'model' => $pembeli,
                'role' => 'pembeli',
                'password' => $pembeli->PASSWORD_PEMBELI // Use PASSWORD_PEMBELI column
            ];
        }

        // Check Organisasi table using EMAIL_ORGANISASI column
        $organisasi = Organisasi::where('EMAIL_ORGANISASI', $email)->first();
        if ($organisasi) {
            return [
                'model' => $organisasi,
                'role' => 'organisasi',
                'password' => $organisasi->PASSWORD_ORGANISASI // Use PASSWORD_ORGANISASI column
            ];
        }

        // If email is not found in any table
        return null;
    }

    /**
     * Determine the role of a Pegawai based on their Jabatan ID.
     */
    private function getPegawaiRole($idJabatan)
    {
        // Fetch the Jabatan record to get the name
        $jabatan = Jabatan::find($idJabatan);

        if ($jabatan) {
            // Return the name of the position as the role (e.g., 'Owner', 'Admin', 'Kepala Gudang')
            // Or map specific IDs to roles if needed
            switch ($jabatan->ID_JABATAN) { // Use ID_JABATAN from the fetched model
                case "JAB001":
                    return 'owner';
                case "JAB002":
                    return 'admin';
                case "JAB003":
                    return 'kepala gudang'; // Specific role name
                case "JAB004":
                    return 'customer service'; // Specific role name
                case "JAB005":
                    return 'hunter';
                case "JAB006":
                    return 'kurir';
                default:
                    return 'pegawai'; // Default role for other Jabatan IDs
            }
        }

        return 'pegawai'; // Default role if Jabatan ID is not found
    }


    /**
     * Create a Sanctum token for the given user with specified role abilities.
     */
    private function createTokenForUser($user, $role)
    {
        // Delete existing tokens for the user
        $user->tokens()->delete();

        // Create a new token with the role as an ability
        // You can add more abilities if needed, e.g., [$role, 'read', 'write']
        return $user->createToken($role . '-token', [$role])->plainTextToken;
    }

    /**
     * Get the role from the authenticated user's current access token abilities.
     */
    private function getRoleFromToken($user)
    {
        // Get abilities from the current token
        $abilities = $user->currentAccessToken()->abilities;

        // Return the first ability found, assuming the role is the primary ability
        if (count($abilities) > 0) {
            return $abilities[0];
        }

        // Default role if no abilities are found
        return 'unknown';
    }

    /**
     * Handle user logout.
     * Requires 'auth:sanctum' middleware on the route.
     */
    public function logout(Request $request)
    {
        // Ensure the user is authenticated via API token
        if (Auth::guard('sanctum')->check()) { // Use 'sanctum' guard
             // Delete the current API token
            $request->user('sanctum')->currentAccessToken()->delete(); // Use 'sanctum' guard

            return response()->json([
                'success' => true,
                'message' => 'Logout berhasil' // Logout successful
            ]);
        }

         return response()->json([
            'success' => false,
            'message' => 'User not authenticated' // User not authenticated
        ], 401);
    }
}
