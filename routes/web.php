<?php

use App\Http\Controllers\PrincipalController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'dashboard');;

Route::get('dashboard', [PrincipalController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('software', [PrincipalController::class, 'software'])
    ->middleware(['auth', 'verified'])
    ->name('software');

Route::get('clientes', [PrincipalController::class, 'clientes'])
    ->middleware(['auth', 'verified'])
    ->name('clientes');

Route::get('clientes/user_cliente/{id}', [PrincipalController::class, 'user_cliente'])
    ->middleware(['auth', 'verified'])
    ->name('user_cliente');

Route::get('licencias', [PrincipalController::class, 'licencias'])
    ->middleware(['auth', 'verified'])
    ->name('licencias');

Route::get('terminales', [PrincipalController::class, 'terminales'])
    ->middleware(['auth', 'verified'])
    ->name('terminales');

Route::get('estados', [PrincipalController::class, 'estados'])
    ->middleware(['auth', 'verified'])
    ->name('estados');

Route::get('etapas', [PrincipalController::class, 'etapas'])
    ->middleware(['auth', 'verified'])
    ->name('etapas');

Route::get('prioridades', [PrincipalController::class, 'prioridades'])
    ->middleware(['auth', 'verified'])
    ->name('prioridades');

Route::get('preguntas', [PrincipalController::class, 'preguntas'])
    ->middleware(['auth', 'verified'])
    ->name('preguntas');

Route::get('preguntas/respuestas/{id}', [PrincipalController::class, 'respuestas'])
    ->middleware(['auth', 'verified'])
    ->name('respuestas');

Route::get('usuarios', [PrincipalController::class, 'usuarios'])
    ->middleware(['auth', 'verified'])
    ->name('usuarios');

Route::get('soportes', [PrincipalController::class, 'soportes'])
    ->middleware(['auth', 'verified'])
    ->name('soportes');

Route::get('licencias/subscripciones/{id_licencia}/{name}', [PrincipalController::class, 'subscripciones'])
->middleware(['auth', 'verified'])
->name('subscripciones');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
