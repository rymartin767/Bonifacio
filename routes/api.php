<?php

use App\Http\Controllers\AirlineController;
use App\Http\Controllers\MonthlyStaffingChartController;
use App\Http\Controllers\ScaleController;
use App\Http\Controllers\SeniorityController;
use App\Http\Controllers\VacancyController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

Route::get('/airlines', [AirlineController::class, 'index'])->middleware('auth:sanctum');
Route::get('/airlines/{airline:icao}', [AirlineController::class, 'show'])->middleware('auth:sanctum');
Route::get('/airlines/{airline:icao}/scales', [ScaleController::class, 'show'])->middleware('auth:sanctum');

Route::get('/vacancyAwards', [VacancyController::class, 'index'])->middleware('auth:sanctum');
Route::get('/award', [VacancyController::class, 'show'])->middleware('auth:sanctum');

Route::get('/seniorities', [SeniorityController::class, 'show'])->middleware('auth:sanctum');
Route::get('/seniorityList', [SeniorityController::class, 'index'])->middleware('auth:sanctum');

Route::get('charts/monthlyStaffing', [MonthlyStaffingChartController::class, 'show'])->middleware('auth:sanctum');
