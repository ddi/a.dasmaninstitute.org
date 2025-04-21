<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//use App\Http\Controllers\AuthController;
//use App\Http\Controllers\Api\V1\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::post("/register", [AuthController::class, "register"]);
// Route::post("/login", [AuthController::class, "login"]);
// Route::get("/login", [AuthController::class, "login"]);

Route::group([
    'prefix' => '/v1',
    'namespace' => 'App\Http\Controllers\Api\V1'
], function () {
    //Route::post('/auth/login', [AuthController::class, 'login']);
    Route::post('/auth/login', 'AuthController@login');
    Route::post('/civilids', 'PatientController@store');
    Route::get('/civilids/{personId}', 'PatientController@show');
});
