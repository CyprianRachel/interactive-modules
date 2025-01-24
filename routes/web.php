<?php

use App\Http\Controllers\ModuleController;
use Illuminate\Support\Facades\Route;

Route::post('/modules', [ModuleController::class, 'store']);
Route::get('/modules/{id}/download', [ModuleController::class, 'download']);

