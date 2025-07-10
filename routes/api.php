<?php

use App\Http\Controllers\Admin\PropertyController as AdminPropertyController;
use App\Http\Controllers\Agent\PropertyController as AgentPropertyController;
use App\Http\Controllers\Buyer\PropertyController as BuyerPropertyController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
        $user = $request->user();
        $user['profile_image'] = asset('storage/' . $user->profile_image);
    return $user;
})->middleware('auth:sanctum');
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/verify', [UserController::class, 'verify']);
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

// Agent Routes
Route::middleware(['auth:sanctum','role:agent'])->controller(AgentPropertyController::class)->group(function () {
    Route::post('/upload', 'upload');
    Route::get('/agent-properties/{id}', 'agentProperties');
});


// Admin Routes
Route::middleware(['auth:sanctum','role:admin'])->controller(AdminPropertyController::class)->group(function () {
    Route::get('/admin-all-properties', 'adminAllProperties');
    Route::patch('/property/{id}', 'updateProperty');
});


//buyer Routes
Route::middleware(['auth:sanctum', 'role:buyer'])->controller(BuyerPropertyController::class)->group(function () {
    Route::get('/buyer-all-properties', 'buyerAllProperties');
    Route::get('/favorite', 'getFavoritedProperties');
    Route::post('/favorite/{id}', 'favorite');
});


