<?php

use Illuminate\Support\Facades\Route;
use Modules\EntretienIndividuel\Http\Controllers\EntretienController;
use Modules\EntretienIndividuel\Http\Controllers\FormulaireController;

Route::get('/hello', function () {
    return response()->json([
        'message' => 'Hello Worldaaa',
        'status' => 'success',
    ], 201);
});

// Entretien routes
Route::prefix('api/entretiens')->group(function () {
    Route::get('/', [EntretienController::class, 'index']);
    Route::post('/', [EntretienController::class, 'store']);
    Route::get('/{id}', [EntretienController::class, 'show']);
    Route::put('/{id}', [EntretienController::class, 'update']);
    Route::delete('/{id}', [EntretienController::class, 'destroy']);
});
Route::get('/', [FormulaireController::class, 'getAll']);
// Formulaire routes
Route::prefix('api/formulaire')->group(function () {
    Route::get('/', [FormulaireController::class, 'getAll']);
    Route::post('/', [FormulaireController::class, 'store']);
    Route::get('/{id}', [FormulaireController::class, 'show']);
    Route::put('/{id}', [FormulaireController::class, 'update']);
    Route::delete('/{id}', [FormulaireController::class, 'destroy']);
});


