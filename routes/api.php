<?php

use App\Http\Controllers\AirlineController;
use App\Http\Controllers\AmeReviewsController;
use App\Http\Controllers\AmesController;
use App\Http\Controllers\AtlasPayRatesController;
use App\Http\Controllers\AwardsController;
use App\Http\Controllers\DomicilesController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeScalesController;
use App\Http\Controllers\MonthlyStaffingChartController;
use App\Http\Controllers\RetirementChartController;
use App\Http\Controllers\SeniorityController;
use App\Http\Controllers\UpgradesController;
use App\Http\Controllers\VacancyController;
use App\Http\Controllers\VerifyEmploymentController;
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

Route::get('verifyEmployment', [VerifyEmploymentController::class, 'show'])->middleware('auth:sanctum');

Route::get('/airlines', [AirlineController::class, 'index'])->middleware('auth:sanctum');
Route::get('/airline', [AirlineController::class, 'show'])->middleware('auth:sanctum');
Route::get('atlasPayRates', AtlasPayRatesController::class)->middleware('auth:sanctum');

Route::get('/vacancyAwards', [VacancyController::class, 'index'])->middleware('auth:sanctum');
Route::get('/award', [VacancyController::class, 'show'])->middleware('auth:sanctum');

// Eventually the master employee route
Route::get('awards', AwardsController::class)->middleware(['auth:sanctum']);
Route::get('employee', EmployeeController::class)->middleware(['auth:sanctum']);

Route::get('upgrades', [UpgradesController::class, 'index'])->middleware('auth:sanctum');

// Seniority List Family
Route::get('seniorities', [SeniorityController::class, 'show'])->middleware('auth:sanctum');
Route::get('seniorityList', [SeniorityController::class, 'index'])->middleware('auth:sanctum');

Route::get('charts/monthlyStaffing', MonthlyStaffingChartController::class)->middleware('auth:sanctum');

Route::get('employeeScales', [EmployeeScalesController::class, 'index'])->middleware('auth:sanctum');
Route::get('employeeRate', [EmployeeScalesController::class, 'show'])->middleware('auth:sanctum');

Route::post('ames', [AmesController::class, 'store'])->middleware('auth:sanctum');
Route::get('ames', [AmesController::class, 'index'])->middleware('auth:sanctum');
Route::delete('ames/{id}', [AmesController::class, 'destroy'])->middleware('auth:sanctum');

Route::get('reviews', [AmeReviewsController::class, 'index'])->middleware('auth:sanctum');
Route::post('reviews', [AmeReviewsController::class, 'store'])->middleware('auth:sanctum');

Route::get('domiciles', [DomicilesController::class, 'index'])->middleware('auth:sanctum');
Route::get('domicile', [DomicilesController::class, 'show'])->middleware('auth:sanctum');

// Apex Charts
Route::get('monthlyStaffingChart', MonthlyStaffingChartController::class)->middleware('auth:sanctum');
Route::get('retirementChart', RetirementChartController::class)->middleware('auth:sanctum');