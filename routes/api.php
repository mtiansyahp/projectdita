<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EquipmentLaboratoriumController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ApprovalPelaporanController;
use App\Http\Controllers\Api\EquipmentSummaryController;


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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    // CRUD equipment
    Route::apiResource('equipment', EquipmentLaboratoriumController::class);
    Route::get('/equipment/{equipment}', function (App\Models\EquipmentLaboratorium $equipment) {
        return $equipment;
    });

    // Logout (opsional)
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/', [UserController::class, 'store']);
    Route::get('{user}', [UserController::class, 'show']);
    Route::put('{user}', [UserController::class, 'update']);
    Route::delete('{user}', [UserController::class, 'destroy']);
});

Route::prefix('approval-pelaporan')->group(function () {
    Route::get('/', [ApprovalPelaporanController::class, 'index']);// untuk mengambil semua data approval pelaporan
    Route::get('/{id}', [ApprovalPelaporanController::class, 'show']); // untuk mengambil data approval pelaporan berdasarkan id
    Route::post('/', [ApprovalPelaporanController::class, 'store']); // untuk menyimpan data approval pelaporan
    Route::put('/{id}', [ApprovalPelaporanController::class, 'update']); // untuk mengupdate data approval pelaporan berdasarkan id
    Route::delete('/{id}', [ApprovalPelaporanController::class, 'destroy']); // untuk menghapus data approval pelaporan berdasarkan id
});


Route::get('equipment-summary', [EquipmentSummaryController::class, 'index']);



Route::post('login', [AuthController::class, 'login']);
