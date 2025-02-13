<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DomainController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/domains', [DomainController::class, 'index'])->name('domains')->middleware("auth");
Route::get('/register-domain', [DomainController::class, 'registerDomainShow'])->name('domain.register.show')->middleware("auth");
Route::post('/register-domain', [DomainController::class, 'registerDomain'])->name('domain.register')->middleware("auth");

Route::fallback([DashboardController::class, 'index']);
