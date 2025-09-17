<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HotelController;

// Routes publiques
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Routes hôtels publiques (lecture seulement)
Route::get('/hotels', [HotelController::class, 'index']);       // Liste des hôtels
Route::get('/hotels/{id}', [HotelController::class, 'show']);   // Détails d'un hôtel

// Routes protégées (nécessitent authentification)
Route::middleware('auth:sanctum')->group(function () {
    // Profil utilisateur
    Route::get('/user', [AuthController::class, 'user']);             // Infos utilisateur connecté
    Route::put('/profile/update', [AuthController::class, 'updateProfile']); // Modifier profil
    Route::post('/logout', [AuthController::class, 'logout']);        // Déconnexion

    // Gestion des hôtels (création, modification, suppression)
    Route::apiResource('hotels', HotelController::class);
});