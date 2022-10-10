<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\JobApplyController;
use App\Http\Controllers\API\JobVacancyController;
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

// authentications
Route::POST('v1/auth/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['user']], function() {
    Route::POST('v1/auth/logout', [AuthController::class, 'logout']);

    // validations
    Route::POST('v1/validations', [ValidationController::class, 'requestValidation']);
    Route::GET('v1/validations', [ValidationController::class, 'getValidation']);
    
    // job vacansies
    Route::GET('v1/job_vacancies', [JobVacancyController::class, 'getJobVacancies']);
    Route::GET('v1/job_vacancies/{id}', [JobVacancyController::class, 'jobVacancyDetail']);
    
    // job apply 
    Route::POST('/v1/applications', [JobApplyController::class, 'jobApply']);
    Route::GET('/v1/applications', [JobApplyController::class, 'societyJobApplication']);

});