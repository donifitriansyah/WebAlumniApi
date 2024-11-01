<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function index(): View
    {
        return view('pages.auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Ambil email dan password dari request
        $email = $request->input('email');
        $password = $request->input('password');

        // Panggil API untuk login
        $response = Http::post('http://127.0.0.1:10/api/auth/login', [
            'email' => $email,
            'password' => $password,
        ]);

        if ($response->successful()) {
            // Jika login berhasil
            $data = $response->json();
            $token = $data['token'];
            $user = $data['user'];
            $role = $data['role'];

            // Simpan token dan informasi pengguna ke session
            session(['token' => $token, 'user' => $user, 'role' => $role]);
            if ($role === 'admin') {
                return redirect()->route('dashboardAdmin')->with('success', $data['message']);
            } elseif ($role === 'alumni') {
                return redirect()->route('dashboardAlumni')->with('success', $data['message']);
            } elseif ($role === 'perusahaan') {
                return redirect()->route('dashboard.perusahaan')->with('success', $data['message']);
            }
            // Redirect ke dashboard atau halaman lain dengan pesan sukses
            return redirect()->route('dashboard')->with('success', $data['message']);
        } elseif ($response->status() === 401) {
            // Jika tidak terautentikasi
            return back()->withErrors(['login_error' => 'Unauthorized. Please check your credentials.']);
        } else {
            // Tangani kesalahan lainnya
            return back()->withErrors(['login_error' => 'An error occurred. Please try again later.']);
        }
    }
}
