<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProjetsController;
use App\Http\Controllers\Api\EtudiantController;


Route::post('register', [EtudiantController::class, 'register']);
Route::post('login', [EtudiantController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('logout', [EtudiantController::class, 'logout']);
    Route::get('profile', [EtudiantController::class, 'profile']);

    Route::post('cree_projet', [ProjetsController::class, 'create']);
    Route::delete('delete_projet', [ProjetsController::class, 'delete']);
    Route::get('list_projet', [ProjetsController::class,'list']);
    Route::get('details_projet', [ProjetsController::class,'details']);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
