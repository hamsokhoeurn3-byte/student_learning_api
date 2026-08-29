<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;

Route::post('/register', [AuthController::class, 'register']);
Route::apiResource('students', StudentController::class);
Route::post('/login', [AuthController::class, 'login']);