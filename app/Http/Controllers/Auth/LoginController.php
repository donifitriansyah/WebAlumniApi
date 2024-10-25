<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function index(): View
    {
        return view('pages.auth.login');
    }
    public function login(Request $request)
    {
        // Validasi data request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Mengonsumsi API login
        $response = Http::post('http://127.0.0.1:10/api/auth/login', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($response->successful()) {
            // Proses jika login berhasil
            $data = $response->json(); // Ambil data JSON dari response

            // Simpan token di session
            session(['token' => $data['token']]); // Simpan token

            // Simpan role di session
            session(['role' => $data['role']]); // Simpan role

            // Set flash message for success
            session()->flash('success', 'Login berhasil!');

            // Simpan nama di session sesuai dengan role
            if ($data['role'] === 'admin') {
                session(['nama' => $data['user']['username']]); // Simpan username untuk admin
            } elseif ($data['role'] === 'alumni') {
                session(['nama' => $data['user']['alumni']['nama_alumni']]); // Simpan nama_alumni untuk alumni
            } elseif ($data['role'] === 'perusahaan') {
                session(['nama' => $data['user']['username']]); // Simpan username untuk perusahaan
            }

            // Redirect berdasarkan role
            if ($data['role'] === 'alumni') {
                return redirect()->route('dashboardAlumni');
            } elseif ($data['role'] === 'admin') {
                return redirect()->route('dashboardAdmin'); // Redirect to admin dashboard
            } elseif ($data['role'] === 'perusahaan') {
                return redirect()->route('dashboardPerusahaan'); // Redirect to perusahaan dashboard
            }
        } else {
            // Proses jika login gagal
            return back()->withErrors(['login_error' => 'Invalid credentials']);
        }
    }
}
