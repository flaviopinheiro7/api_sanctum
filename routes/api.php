<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Services\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/status', function(){
    return ApiResponses::success('API is running OK!');
})->middleware('auth:sanctum');

Route::apiResource('clients', ClientController::class)->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
