<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\InventoryManagerController;


use App\Http\Controllers\MemberController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TlController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);

Route::controller(AdminController::class)->group(function () {
    Route::get('/user-list', 'userList');
    Route::get('/user-list-search', 'userListSearch');
    Route::post('/add-user', 'addUser');
    Route::delete('/delete-user/{id}', 'deleteUser');
    Route::get('/updated-user-data/{id}', 'userUpdatedData');
    Route::post('/update-user-data/{id}', 'userUpdateData');
    Route::post('/new-item', 'newItem');
    Route::get('/get-items', 'getItems');
    Route::get('/item-category', 'itemCategory');
    Route::get('/items-search', 'itemsSearch');
    Route::delete('/delete-item/{id}', 'deleteItem');
    Route::get('/updated-item/{id}', 'updatedItem');
    Route::post('/update-item/{id}', 'updateitem');
    Route::get('/view-item/{id}', 'viewItem');
    Route::get('/scheduled-date/{date}', 'scheduledDate');
    Route::post('/add-schedule', 'addSchedule');
    // Route::get('/generate-barcode', 'generateBarcode');
    Route::get('/view-scan-barcode/{barcode}', 'viewScanBarcode');
    Route::get('/edit-quantity/{id}', 'editQuantity');
    Route::post('/add-quantity-submit/{id}', 'addQuantitySubmit');
    Route::post('/reduce-quantity-submit/{id}', 'reduceQuantity');
    route::post('/save-scanned-items', 'saveScannedItems');
    route::get('/get-scanned-items/{id}', 'getScannedItems');
    route::post('/save-scanned-items-out', 'saveScannedItemsOut');
    route::get('/get-scanned-items-out/{id}', 'getScannedItemsOut');

    route::get('admin-get-item', 'getItem');
    Route::get('/admin-item-search-list', 'itemSearchlist');
    route::get('admin-get-date-schedule', 'getDateSchedule');
    route::get('/admin-schedule-list', 'scheduleList');
    route::post('/admin-update-schedule-status', 'updateScheduleStatus');
    route::get('/count-status', 'countStatus');
    route::get('/category', 'category');

    route::get('category-list-category', 'categoryListCategory');
    route::get('category-list-table', 'categoryListTable');

    route::get('get-update-category-list', 'getUpdateCategoryList');
    route::post('update-category-list', 'updateCategoryList');
    route::get('delete-category', 'deleteCategory');

    route::get('get-treshold', 'getTreshold');
    route::post('update-treshold', 'updateTreshold');

    route::get('get-quantity', 'getQuantity');
    route::post('update-quantity', 'updateQuantity');



    route::get('/low-stock-alert', 'lowStockAlert');
    route::post('/change-password', 'changePassword');

    route::get('/stock-category', 'stockCategory');
    route::get('/get-stock', 'getStock');

    //category list function
    route::post('/post-category', 'postCategory');
    Route::get('/test', 'test');
    // route::get('/test/{category}/{search}','test');
});

Route::controller(InventoryManagerController::class)->group(function () {
    Route::get('/IM_get_item_list', 'getItemList');
    Route::get('/IM_item-search-list', 'itemSearchList');
    Route::get('/IM_update-item/{id}', 'getUpdatedItem');
    Route::post('/IM_submit-updated-item/{id}', 'submitUpdatedItem');


    route::get('/IM-get-item', 'getItem');
    Route::get('/IM-item-search-list', 'itemSearchlists');
    route::get('/IM-get-date-schedule', 'getDateSchedule');
    route::get('/IM-schedule-list', 'scheduleList');
    route::post('/IM-update-schedule-status', 'updateScheduleStatus');
    route::get('status-count', 'statusCount');
    route::get('/IM-category-list', 'category');
});


Route::controller(MemberController::class)->group(function () {
    Route::get('/member-get-item', 'getItem');
    Route::get('/member-item-search-list', 'itemSearchList');
    route::get('/member-category-list', 'category');
});

Route::controller(TlController::class)->group(function () {
    route::get('tl-item-category', 'itemCategory');
    Route::get('/tl-items', 'items');
    route::get('tl-get-date-schedule', 'getDateSchedule');
    route::get('/tl-schedule-list', 'scheduleList');
    route::post('/tl-update-schedule-status', 'updateScheduleStatus');
    route::get('/tl-status-count', 'countStatus');
});

Route::controller(ChartController::class)->group(function () {
    route::get('/bargraph', 'bargraph');
    route::get('/linegraph', 'lineGraph');
    route::get('/piegraph', 'pieGraph');
    route::get('/dashboard-count', 'dashboardCount');
});

route::controller(HistoryController::class)->group(function () {
    Route::post('/create-in-history', 'createInHistory');
    route::post('/create-out-history', 'createOutHistory');
    route::get('/get-in-history', 'getInHistory');
});


Route::post('/low-stock-email', [AnnouncementController::class, 'lowStockAlert']);

route::get('/notification-table', [NotificationController::class, 'getNotificationTable']);
