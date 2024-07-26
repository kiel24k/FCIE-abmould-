<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login',[AuthController::class, 'login']);

Route::controller(AdminController::class)->group(function () {
    Route::get('/user-list', 'userList');
    Route::post('/add-user', 'addUser');
    Route::delete('/delete-user/{id}', 'deleteUser');
    Route::get('/updated-user-data/{id}','userUpdatedData');
    Route::post('/update-user-data/{id}', 'userUpdateData');
    Route::post('/new-tools', 'newItemTools');
    Route::post('/new-material', 'newMaterial');
    Route::get('/get-materials', 'getMaterials');
    Route::delete('/delete-material/{id}', 'deleteMaterial');
    Route::get('/updated-material/{id}', 'updatedMaterial');
    Route::post('/update-material/{id}', 'updateMaterial');
    Route::get('/scheduled-date/{date}', 'scheduledDate');
});
