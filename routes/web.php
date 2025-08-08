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