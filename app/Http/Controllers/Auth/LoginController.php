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
    $response = Http::post('http://127.0.0.1:8000/api/auth/login', [
        'email' => $request->email,
        'password' => $request->password,
    ]);

    // // Log respons dari API
    // Log::info('API Login Response:', [
    //     'status' => $response->status(),
    //     'data' => $response->json(),
    // ]);

    if ($response->successful()) {
        // Proses jika login berhasil
        $data = $response->json(); // Ambil data JSON dari response

        // Simpan token dan role di session
        session(['token' => $data['token']]); // Simpan token
        session(['role' => $data['role']]); // Simpan role
        session(['username' => $data['user']['username']]); // Simpan username

        // Tampilkan informasi respons di halaman dashboard
        return view('pages.admin.dashboard', ['user' => $data['user']]); // Mengirimkan data user ke view
    } else {
        // Proses jika login gagal
        return back()->withErrors(['login_error' => 'Invalid credentials']);
    }

}


}


