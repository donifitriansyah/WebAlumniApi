<?php

use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Alumni\DashboardAlumniController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

//Register Alumni
Route::get('register-alumni', [RegisterController::class, 'indexAlumni'])->name('indexAlumni');

Route::post('register', [RegisterController::class, 'registerAlumni'])->name('registerAlumni');

Route::get('dashboard', [DashboardAlumniController::class, 'index'])->name('dashboardAlumni');

//Admin
Route::get('dashboard', [DashboardAdminController::class, 'index'])->name('dashboardAdmin');
Route::get('berita', [BeritaController::class, 'index'])->name('berita.index');

