<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ValidationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// authentication
Route::POST('v1/auth/login', [AuthController::class, 'login']);
Route::POST('v1/auth/logout', [AuthController::class, 'logout']);


// validations
Route::POST('v1/validation', [ValidationController::class, 'requestValidation']);
Route::GET('v1/validations', [ValidationController::class, 'getValidation']);