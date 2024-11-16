<?php

use App\Http\Controllers\API\FiliereController;
use App\Http\Controllers\RapportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('api')->group(function () {
    Route::resource('filieres', FiliereController::class);
    });
    Route::get('/filieres', [FiliereController::class, 'index']);
    Route::middleware('api')->group(function () {
        Route::resource('rapports', RapportController::class);});   
        Route::get('filieres/{id}/rapports', [FiliereController::class, 'getRapports']);
        Route::get('/listrapports/{idfil}', [RapportController::class,'showRapportByFIL']);
        Route::get('/rapports/rap/rapportspaginate', [RapportController::class,
'rapportsPaginate']);