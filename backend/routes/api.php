<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('residents', App\Http\Controllers\API\ResidentAPIController::class)
    ->except(['create', 'edit']);

Route::resource('residents', App\Http\Controllers\API\ResidentAPIController::class)
    ->except(['create', 'edit']);

Route::resource('users', App\Http\Controllers\API\UserAPIController::class)
    ->except(['create', 'edit']);

Route::resource('residents', App\Http\Controllers\API\ResidentAPIController::class)
    ->except(['create', 'edit']);

Route::resource('houses', App\Http\Controllers\API\HouseAPIController::class)
    ->except(['create', 'edit']);

Route::resource('house-residents', App\Http\Controllers\API\HouseResidentAPIController::class)
    ->except(['create', 'edit']);

Route::resource('payments', App\Http\Controllers\API\PaymentAPIController::class)
    ->except(['create', 'edit']);

Route::resource('expenses', App\Http\Controllers\API\ExpenseAPIController::class)
    ->except(['create', 'edit']);
