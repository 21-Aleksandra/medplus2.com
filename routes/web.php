<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AppointmentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('homepage');
});

Route::get('/doctors', [DoctorController::class, 'index']);
Route::resource('doctor', DoctorController::class);

Route::post('/doctors/{doctorname}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::post('/doctors/search', [DoctorController::class, 'index'])->name('doctor.search');
Route::delete('/doctors/delete', [DoctorController::class, 'delete'])->name('doctors.delete');

Route::get('/doctor/{doctorname}', [DoctorController::class, 'show'])->name('doctor.show');


Route::get('/doctors/{doctorname}/edit', [DoctorController::class, 'edit'])->name('editdoc.edit');
Route::put('/doctors/{id}', [DoctorController::class, 'update'])->name('editdoc.update');
Route::get('/doctors/create', [DoctorController::class, 'create'])->name('doctors.create');
Route::post('/doctors', [DoctorController::class, 'store'])->name('doctors.store');

Route::get('/comments', [CommentController::class, 'index'])->name('comments.index');

Route::delete('/comments/delete', [CommentController::class, 'delete'])->name('comments.delete');

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::post('/users/actions', [UserController::class, 'actions'])->name('users.actions');

Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');

Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');

Route::patch('/appointments/{appointment}', [AppointmentController::class, 'update'])->name('appointments.update');
Route::post('/appointments/update-status', [AppointmentController::class, 'updateStatus'])->name('appointments.updateStatus');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    // Appointment routes
    Route::get('/profile/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/profile/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
});

Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');

require __DIR__.'/auth.php';
