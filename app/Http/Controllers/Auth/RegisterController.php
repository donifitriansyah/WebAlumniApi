<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function indexAlumni(): View
    {
        return view('pages.auth.register_alumni');
    }

    public function registerAlumni(Request $request)
    {
        // Validate data request
        $request->validate([
            'username' => 'required|string',
            'nim' => 'required|string',
            'nama_alumni' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'no_tlp' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string',
            'password_confirmation' => 'required|string|same:password',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Prepare data for API consumption
        $data = [
            'username' => $request->username,
            'nim' => $request->nim,
            'nama_alumni' => $request->nama_alumni,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'no_tlp' => $request->no_tlp,
            'email' => $request->email,
            'password' => $request->password,
            'password_confirmation' => $request->password_confirmation,
        ];

        // Include the file if it exists
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto'); // Attach the file directly
        }

        // Consume API for alumni registration
        $response = Http::attach('foto', fopen($request->file('foto')->getRealPath(), 'r'), $request->file('foto')->getClientOriginalName())
            ->post(env('API_BASE_URL') . '/api/auth/register-alumni', $data);

        // Check for successful response
        if ($response->successful()) {
            // Process if registration is successful
            $data = $response->json(); // Get JSON data from response

            // Save token and role in session
            session(['token' => $data['token']]); // Save token
            session(['role' => $data['user']['role']]); // Save role
            session(['username' => $data['user']['username']]); // Save username
            session(['nama' => $data['nama_alumni']]); // Save username

            // Show response information on dashboard page
            return view('pages.admin.dashboard', ['user' => $data['user']]); // Send user data to view
        } else {
            // Log the error response from the API
            Log::error('Registration failed', [
                'response_status' => $response->status(),
                'response_data' => $response->json(),
            ]);

            // Handle API error response
            $errorMessage = $response->json()['message'] ?? 'Registration failed';
            $additionalErrors = $response->json()['errors'] ?? []; // Assuming the API returns detailed errors

            // Create an array to store all errors
            $allErrors = [$errorMessage];

            // Merge additional errors if any
            if (is_array($additionalErrors) && count($additionalErrors) > 0) {
                // Flatten the errors array if it is structured with keys
                foreach ($additionalErrors as $key => $messages) {
                    if (is_array($messages)) {
                        $allErrors = array_merge($allErrors, $messages);
                    } else {
                        $allErrors[] = $messages;
                    }
                }
            }

            // Return back with all errors
            return back()->withErrors(['registration_error' => $allErrors]);
        }
    }
}
