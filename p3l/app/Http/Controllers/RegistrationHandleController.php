<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\PembeliController;
use App\Http\Controllers\PenitipController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\OrganisasiController;
use Illuminate\Support\Facades\Validator; // Import Validator facade

class RegistrationHandleController extends Controller
{
    /**
     * Handle registration requests based on the selected role.
     */
    public function handleRegistration(Request $request)
    {
        // Basic validation for the role field
        $request->validate([
            'role' => 'required|in:pembeli,penitip,pegawai,organisasi',
            // You might want to add basic validation for other common fields here as well
            // e.g., 'email' => 'required|email', 'password' => 'required|min:8',
        ]);

        $role = $request->role;

        // Based on the role, call the appropriate controller's store method
        try {
            switch ($role) {
                case 'pembeli':
                    // Create an instance of PembeliController and call its store method
                    $controller = new PembeliController();
                    return $controller->store($request); // Pass the original request

                case 'penitip':
                    // Create an instance of PenitipController and call its store method
                    $controller = new PenitipController();
                    return $controller->store($request); // Pass the original request

                case 'pegawai':
                    // Create an instance of PegawaiController and call its store method
                    // Note: Pegawai registration requires ID_JABATAN. You'll need to handle this.
                    // Perhaps add a 'jabatan_id' field to the form or have a default.
                    $controller = new PegawaiController();
                    return $controller->store($request); // Pass the original request

                case 'organisasi':
                    // Create an instance of OrganisasiController and call its store method
                    $controller = new OrganisasiController();
                    return $controller->store($request); // Pass the original request

                default:
                    // Should not be reached due to 'in' validation rule, but as a fallback
                    return response()->json([
                        'status' => false,
                        'message' => 'Invalid role selected.',
                    ], 400);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            // If validation fails in the specific controller's store method
            return response()->json([
                'status' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422); // 422 Unprocessable Entity for validation errors
        } catch (\Exception $e) {
            // Catch any other exceptions during registration
             return response()->json([
                'status' => false,
                'message' => 'Registration failed.',
                'data' => $e->getMessage(),
            ], 500); // 500 Internal Server Error
        }
    }
}
