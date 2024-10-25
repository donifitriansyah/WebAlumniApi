<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function logout(Request $request)
    {

        // Atau jika Anda menggunakan JWT, Anda dapat memanggil API untuk mencabut token
        $token = $request->session()->get('token');
        $response = Http::withToken($token)->post('http://127.0.0.1:10/api/auth/logout');

        return redirect()->route('login')->with('message', 'You have been logged out successfully.');
    }
}
