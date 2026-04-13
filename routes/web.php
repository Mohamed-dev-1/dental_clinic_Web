<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('home');
});

// Login | Register | Logout ROUTES :

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('showRegister');

Route::post('/login', [AuthController::class, 'login'])->name('doLogin');
Route::post('/register', [AuthController::class, 'register'])->name('doRegister');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


use App\Http\Controllers\DoctorController;

// Doctor dashboard routes

Route::middleware(['auth'])->group(function () {
    Route::get('/doctor/dashboard', [DoctorController::class, 'index'])->name('doctor.dashboard');
    Route::get('/doctor/search', [DoctorController::class, 'searchPatient'])->name('doctor.search');
    Route::delete('/doctor/patient/{id}', [DoctorController::class, 'deletePatient'])->name('doctor.deletePatient');
    Route::get('/doctor/medical/{patientId}/create', [DoctorController::class, 'createMedicalDocument'])->name('doctor.createMedical');
    Route::post('/doctor/medical/store', [DoctorController::class, 'storeMedicalDocument'])->name('doctor.storeMedical');
    Route::patch('/doctor/appointment/{id}/accept', [DoctorController::class, 'acceptAppointment'])->name('doctor.acceptAppointment');
    Route::patch('/doctor/appointment/{id}/reject', [DoctorController::class, 'rejectAppointment'])->name('doctor.rejectAppointment');
});



use App\Http\Controllers\PatientController;

// Patient routes
Route::middleware(['auth'])->group(function () {
    Route::get('/patient/dashboard', [PatientController::class, 'index'])->name('patient.dashboard');
    Route::post('/patient/profile/update', [PatientController::class, 'updateProfile'])->name('patient.updateProfile');
    Route::post('/patient/password/update', [PatientController::class, 'updatePassword'])->name('patient.updatePassword');
    Route::delete('/patient/account/delete', [PatientController::class, 'deleteAccount'])->name('patient.deleteAccount');
    Route::post('/patient/notes/save', [PatientController::class, 'saveNote'])->name('patient.saveNote');
    Route::post('/patient/appointment/book', [PatientController::class, 'bookAppointment'])->name('patient.bookAppointment');
    Route::patch('/patient/appointment/{id}/cancel', [PatientController::class, 'cancelAppointment'])->name('patient.cancelAppointment');
    Route::patch('/patient/notification/{id}/read', [PatientController::class, 'markNotificationRead'])->name('patient.markNotificationRead');
    Route::patch('/patient/notifications/read-all', [PatientController::class, 'markAllNotificationsRead'])->name('patient.markAllNotificationsRead');
});
