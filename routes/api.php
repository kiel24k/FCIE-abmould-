<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InventoryManagerController;


use App\Http\Controllers\MemberController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login',[AuthController::class, 'login']);

Route::controller(AdminController::class)->group(function () {
    Route::get('/user-list', 'userList');
    Route::get('/user-list-search', 'userListSearch');
    Route::post('/add-user', 'addUser');
    Route::delete('/delete-user/{id}', 'deleteUser');
    Route::get('/updated-user-data/{id}','userUpdatedData');
    Route::post('/update-user-data/{id}', 'userUpdateData');
    Route::post('/new-item', 'newItem');
    Route::get('/get-items', 'getItems');
    Route::get('/item-category','itemCategory');
    Route::get('/items-search','itemsSearch');
    Route::delete('/delete-item/{id}', 'deleteItem');
    Route::get('/updated-item/{id}', 'updatedItem');
    Route::post('/update-item/{id}', 'updateitem');
    Route::get('/scheduled-date/{date}', 'scheduledDate');
    Route::post('/add-schedule', 'addSchedule');
    // route::get('/test/{category}/{search}','test');
});

Route::controller(InventoryManagerController::class)->group(function () {
    Route::get('/IM_get_item_list', 'getItemList');
    Route::get('/IM_item-search-list', 'itemSearchList');
    Route::get('/IM_update-item/{id}','getUpdatedItem');
    Route::post('/IM_submit-updated-item/{id}', 'submitUpdatedItem');
});



Route::controller(MemberController::class)->group(function () {
    Route::get('/member-get-item', 'getItem');
    Route::get('/member-item-search-list', 'itemSearchList');
});

