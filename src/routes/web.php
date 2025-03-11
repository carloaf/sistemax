<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\RelatorioController;
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
Route::get('/documentos/fornecimento', [DocumentoController::class, 'fornecimento'])
    ->name('documentos.fornecimento');
Route::post('/documentos/fornecimento', [DocumentoController::class, 'storeFornecimento'])
    ->name('documentos.fornecimento.store');

Route::prefix('relatorios')->group(function () {
    Route::get('/entrada', [RelatorioController::class, 'entrada'])->name('relatorios.entrada');
    Route::get('/movimentacoes', [RelatorioController::class, 'movimentacoes'])->name('relatorios.movimentacoes');
    Route::get('/estoque', [RelatorioController::class, 'estoque'])->name('relatorios.estoque');
    Route::get('/relatorios/estoque/{material}/movimentacoes', [RelatorioController::class, 'movimentacoesMaterial'])
        ->name('relatorios.estoque.movimentacoes');
    Route::get('/relatorios/entrada/pdf', [RelatorioController::class, 'entradaPdf'])
        ->name('relatorios.entrada.pdf');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
