<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentoController;
use Illuminate\Support\Facades\Route;


/** set side bar active */
function set_active($route) {
    if( is_array($route) ) {
        return in_array(Request::path(), $route) ? 'active' : '';
    }
    return Request::path() == $route || Request::is($route) ? 'active' : '';
}

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('documentos')->group(function () {
    Route::get('/entrada', [DocumentoController::class, 'create'])->name('documentos.entrada');
    Route::post('/entrada', [DocumentoController::class, 'store'])->name('documentos.entrada.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
