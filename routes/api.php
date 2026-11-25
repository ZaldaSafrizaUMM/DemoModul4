<?php

use App\Http\Controllers\Api\MediaController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

// CRUD lengkap untuk Media
Route::apiResource('media', MediaController::class);

// Endpoint melihat daftar & detail User beserta koleksinya
Route::get('users', [UserController::class, 'index']);
Route::get('users/{user}', [UserController::class, 'show']);

// Custom Action: tambah & hapus media di koleksi User
Route::post('users/{user}/collection', [UserController::class, 'addToCollection']);
Route::delete('users/{user}/collection/{media}', [UserController::class, 'removeFromCollection']);