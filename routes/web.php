<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PatientController;
use App\Http\Middleware\NurseMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', [PatientController::class, 'landing'])->name('landing');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(NurseMiddleware::class)->group(function () {
    Route::get('/nurse', [PatientController::class, 'nurseDashboard'])->name('nurse_dashboard');
    Route::post('/nurse', [PatientController::class, 'addPatient']);
});

Route::get('/patient/{id}', [PatientController::class, 'patientDetail'])->name('patient_detail');
Route::post('/patient/{id}', [PatientController::class, 'updateCondition'])->middleware(NurseMiddleware::class);
Route::get('/access/{id}', [PatientController::class, 'accessPatient'])->name('access_patient');
Route::post('/access/{id}', [PatientController::class, 'verifyAccess']);

/*
|--------------------------------------------------------------------------
| API Routes untuk React Frontend
|--------------------------------------------------------------------------
| Semua route di bawah ini akan mengembalikan data dalam bentuk JSON
| dan bisa diakses dari frontend React + Tailwind.
*/

// Ambil semua pasien
Route::get('/api/patients', [PatientController::class, 'apiGetPatients']);

// Ambil detail pasien
Route::get('/api/patients/{id}', [PatientController::class, 'apiGetPatientById']);

// Tambah pasien baru
Route::post('/api/patients', [PatientController::class, 'apiAddPatient']);

// Update pasien
Route::put('/api/patients/{id}', [PatientController::class, 'apiUpdatePatient']);

// Hapus pasien
Route::delete('/api/patients/{id}', [PatientController::class, 'apiDeletePatient']);
