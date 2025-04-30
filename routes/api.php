<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\InventoryManagerController;
use App\Http\Controllers\LogsController;
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
    route::get('/user-list-category', 'userListCategory');
    Route::get('/user-list', 'userList');
    Route::post('/add-user', 'addUser');
    route::get('/view-user', 'viewUser');
    Route::delete('/delete-user', 'deleteUser');
    Route::get('/updated-user-data/{id}', 'userUpdatedData');
    Route::post('/update-user-data/{id}', 'userUpdateData');
    Route::post('/new-item', 'newItem');
    Route::get('/get-item-list', 'getItemList');
    Route::get('/item-list-category', 'itemListCategory');
    Route::get('/items-search', 'itemsSearch');
    Route::delete('/delete-item/{id}', 'deleteItem');
    Route::get('/updated-item/{id}', 'updatedItem');
    Route::post('/update-item/{id}', 'updateitem');
    Route::get('/view-item/{id}', 'viewItem');
    Route::get('/scheduled-date/{date}', 'scheduledDate');
    route::get('/choose-item-for-schedule', 'chooseItemForSchedule');
    route::get('/schedule-data-per-category', 'getScheduleDataPerCategory');
    Route::post('/add-schedule', 'addSchedule');
    route::get('/get-schedule-request', 'getScheduleRequest');
    route::post('/not-approved-schedule', 'notApproveSchedule');
    route::post('/approve-schedule', 'approveSchedule');
    route::delete('/delete-schedule-request', 'deleteScheduleRequest');
    // Route::get('/generate-barcode', 'generateBarcode');
    Route::get('/view-scan-barcode', 'viewScanBarcode');
    Route::get('/edit-quantity/{id}', 'editQuantity');
    Route::post('/add-quantity-submit', 'addQuantitySubmit');
    Route::post('/reduce-quantity-submit', 'reduceQuantity');
    route::post('/save-scanned-items', 'saveScannedItems');
    route::get('/get-scanned-items/{id}', 'getScannedItems');
    route::post('/save-scanned-items-out', 'saveScannedItemsOut');
    route::get('/get-scanned-items-out/{id}', 'getScannedItemsOut');

    route::get('admin-get-item', 'getItem');
    Route::get('/admin-item-search-list', 'itemSearchlist');
    route::get('admin-get-date-schedule', 'getDateSchedule');
    route::get('/admin-schedule-list', 'scheduleList');
    route::post('/admin-update-schedule', 'updateSchedule');
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

    route::post('/assign-role', 'assignRole');

    //category list function
    route::post('/post-category', 'postCategory');
    Route::get('/test', 'test');
    // route::get('/test/{category}/{search}','test');
});

Route::controller(InventoryManagerController::class)->group(function () {
    route::get('/IM_item_category', 'itemCategory');
    Route::get('/IM-get-item-list', 'getItemList');
    Route::get('/IM_item-search-list', 'itemSearchList');
    Route::get('/IM_update-item/{id}', 'getUpdatedItem');
    Route::post('/IM_submit-updated-item/{id}', 'submitUpdatedItem');
    route::delete('/delete-item', 'deleteItem');


    route::get('/IM-get-item', 'getItem');
    Route::get('/IM-item-search-list', 'itemSearchlists');
    route::get('/IM-get-date-schedule-category', 'getDateScheduleCategory');
    route::get('/IM-schedule-list', 'scheduleList');
    route::post('/IM-update-schedule-status', 'updateScheduleStatus');
    route::get('status-count', 'statusCount');
    route::get('/IM-category-list', 'category');
});


Route::controller(MemberController::class)->group(function () {
    Route::get('/member-item-category', 'itemCategory');
    route::get('/member-item-list', 'itemList');
    // route::get('/member-category-list', 'category');
});

Route::controller(TlController::class)->group(function () {
    Route::get('/tl-item-category', 'itemCategory');
    route::get('/tl-item-list', 'itemList');

    route::get('/tl-schedule-list-category','scheduleListCategory');
    route::get('/tl-schedule-list', 'scheduleList');
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
    route::get('/table-data-dashboard', 'tableDataDashboard');
});

route::controller(HistoryController::class)->group(function () {
    Route::post('/create-in-history', 'createInHistory');
    route::post('/create-out-history', 'createOutHistory');
    route::get('/get-in-history', 'getInHistory');
});

route::controller(LogsController::class)->group(function () {
    route::post('treshold-logs', 'tresholdLogs');
    route::get('get-logs', 'getLogs');
    route::get('test', 'test');
    route::delete('remove-logs', 'removeLogs');

    route::get('get-item-logs', 'getItemLogs');
    route::delete('remove-item-logs', 'removeItemLogs');
});

route::controller(CategoryController::class)->group(function () {
 route::get('all-item-category', 'allItemCategory');
 route::get('schedule-item-category', 'scheduleItemCategory');

 
});

route::controller(NotificationController::class)->group(function () {
    route::get('/low-stock-alert', 'lowStockAlert');
 

});



