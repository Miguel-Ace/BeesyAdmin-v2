<?php

use App\Http\Controllers\PrincipalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/payvalida/webhook');
Route::get('/payvalida/webhook', [PrincipalController::class, 'handleWebhook']);
