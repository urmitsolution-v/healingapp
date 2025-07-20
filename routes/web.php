<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\Admincontroller;
use App\Http\Controllers\Admin\Stockcontroller;
use App\Http\Controllers\Admin\Settingcontroller;
use App\Http\Controllers\Healing\Commoncontroller;
use App\Http\Controllers\Healing\Healingcontroller;
use App\Http\Controllers\Authcontroller;
use App\Http\Middleware\AdminLogin;
use App\Http\Middleware\User;
use App\Http\Middleware\Admin;

Route::get('/admin/login', [Authcontroller::class, 'login']);
Route::get('/logout', [Authcontroller::class, 'logout']);
Route::get('/logoutadmin', [Admincontroller::class, 'logoutadmin']);
Route::post('/loginSubmit', [Authcontroller::class, 'loginSubmit']);
Route::get('/sign-in', [Commoncontroller::class, 'signIn'])->name('healing.signIn');
Route::post('/login', [Commoncontroller::class, 'login'])->name('user.login.submit');
Route::get('/sign-up', [Commoncontroller::class, 'signUp'])->name('healing.signUp');
Route::get('/declearation', [Commoncontroller::class, 'declearation'])->name('healing.declearation');
Route::post('/register-user', [Commoncontroller::class, 'register_store']);
Route::post('/final-submit', [Commoncontroller::class, 'finalSubmit'])->name('user.final.submit');

Route::middleware([User::class])->group(function () {
Route::get('/', [Commoncontroller::class, 'index'])->name('healing.index');
Route::get('/healing-requests', [Healingcontroller::class, 'healing_requests'])->name('healing_requests');
Route::get('/new-healing-request', [Healingcontroller::class, 'new_healing_request'])->name('new_healing_request');
Route::post('/submit-healing-request', [HealingController::class, 'storeHealingRequest']);
Route::get('/user/healing-requests', [HealingController::class, 'getUserRequests']);
Route::post('/user/cancel-healing-request', [HealingController::class, 'healing_cancel']);

Route::get('/view-open-bids', [HealingController::class, 'viewopenbids']);

Route::get('/healer/available-requests', [HealingController::class, 'getAvailableRequestsForBid']);
Route::post('/healer/place-bid', [HealingController::class, 'placeBid']);
Route::get('/assigned-healings', [HealingController::class, 'assigned_healings']);
Route::get('/reports', [HealingController::class, 'reports']);
Route::get('/healer/today-healings', [HealingController::class, 'ajaxHealingList']);
Route::post('/healer/mark-done', [HealingController::class, 'ajaxMarkDone']);

Route::get('/healer/reports/fetch', [HealingController::class, 'fetch_reports']);

});




// --admin 
Route::middleware([Admin::class])->group(function () {
    Route::get('/dashboard', [Admincontroller::class, 'dashboard']);

    Route::prefix('admin')->group(function () {
    Route::get('/users-list', [Admincontroller::class, 'users_list']);
    Route::match(['get','post'],'/add-user', [Admincontroller::class, 'add_user']);
    Route::match(['get','post'],'/delete-user/{id}', [Admincontroller::class, 'deleteuser']);
    Route::match(['get','post'],'/view-user/{id}', [Admincontroller::class, 'view_user']);
    Route::match(['get','post'],'/edit-user/{id}', [Admincontroller::class, 'edit_user']);
    Route::get('/getUserdata', [Admincontroller::class, 'getUserdata'])->name('admin.getUserdata');
    Route::post('/update-user-status', [Admincontroller::class, 'updateUserStatus'])->name('admin.updateUserStatus');
    Route::post('/admin/update-user-block-status', [Admincontroller::class, 'updateUserBlockStatus'])->name('admin.updateUserBlockStatus');
    
    
    Route::get('/healing-request', [Admincontroller::class, 'healing_request'])->name('healing_request');
    Route::get('/admin/get-healing-requests', [Admincontroller::class, 'getHealingRequests'])->name('admin.getHealingRequests');
    Route::post('/healing-requests/update', [Admincontroller::class, 'update_healing_records'])->name('admin.healingRequests.update');
    Route::get('/healing-requests/view-bids/{id}', [Admincontroller::class, 'viewbids'])->name('admin.healingRequests.viewbids');
    Route::post('/assign-healer', [Admincontroller::class, 'assignHealer'])->name('assign.healer');

    
    });
    
    Route::get('/state-list', [Admincontroller::class, 'state_list'])->name('state_list')->middleware(['admin', 'check.permission:location_master.view']);
    Route::match(['get','post'],'/edit-state/{id}', [Admincontroller::class, 'edit_state'])->name('edit_state');
    Route::match(['get','post'],'/new-state', [Admincontroller::class, 'new_state'])->name('new_state');
    Route::match(['get','post'],'/delete-state/{id}', [Admincontroller::class, 'delete_state'])->name('delete_state');
    Route::match(['get','post'],'/delete-city/{id}', [Admincontroller::class, 'delete_city'])->name('delete_city');

    Route::get('/city-list', [Admincontroller::class, 'city_list'])->name('city_list')->middleware(['admin', 'check.permission:location_master.view']);
    Route::match(['get','post'],'/new-city', [Admincontroller::class, 'new_city'])->name('new_city');
    Route::match(['get','post'],'/edit-city/{id}', [Admincontroller::class, 'edit_city'])->name('edit_city');
    
    
    Route::match(['get','post'],'/category-list', [Admincontroller::class, 'category_list'])->name('category_list')->middleware(['admin', 'check.permission:location_master.view']);
    Route::match(['get','post'],'/videos', [Admincontroller::class, 'videos'])->name('videos')->middleware(['admin', 'check.permission:videos.view']);
    Route::match(['get','post'],'/delete-video/{id}', [Admincontroller::class, 'deleteAnimalBuySell'])->name('deleteAnimalBuySell');
    Route::match(['get','post'],'/new-category', [Admincontroller::class, 'new_category'])->name('new_category');
    Route::match(['get','post'],'/edit-category/{id}', [Admincontroller::class, 'edit_category'])->name('edit_category');
    Route::match(['get','post'],'/delete-category/{id}', [Admincontroller::class, 'delete_category'])->name('delete_category');

    Route::match(['get','post'],'/villages-list', [Admincontroller::class, 'villages_list'])->name('villages_list')->middleware(['admin', 'check.permission:location_master.view']);
    Route::match(['get','post'],'/new-village', [Admincontroller::class, 'new_village'])->name('new_village');
    Route::match(['get','post'],'/edit-village/{id}', [Admincontroller::class, 'edit_village'])->name('edit_village');
    Route::match(['get','post'],'/delete-village/{id}', [Admincontroller::class, 'delete_village'])->name('delete_village');


    Route::match(['get','post'],'/supplier-bills', [Admincontroller::class, 'supplier_bills'])->name('supplier_bills')->middleware(['admin', 'check.permission:bills.view']);
    Route::match(['get','post'],'/new-supplier-bill', [Admincontroller::class, 'new_supplier_bill'])->name('new_supplier_bill');
    Route::match(['get','post'],'/edit-supplier-bill/{id}', [Admincontroller::class, 'edit_supplier_bill'])->name('edit_supplier_bill');
    Route::match(['get','post'],'/bullview', [Admincontroller::class, 'bullview'])->name('bullview')->middleware(['admin', 'check.permission:bull_details.view']);
    Route::match(['get','post'],'/new-bull', [Admincontroller::class, 'new_bull'])->name('new_bull');
    Route::match(['get','post'],'/bulls/{id}/edit', [Admincontroller::class, 'edit_bull'])->name('edit_bull');

    Route::match(['get','post'],'/advertisement', [Admincontroller::class, 'advertisement'])->name('advertisement')->middleware(['admin', 'check.permission:advertisement.view']);
    Route::match(['get','post'],'/new-advertisement', [Admincontroller::class, 'new_advertisement'])->name('new_advertisement');
    Route::match(['get','post'],'/advertisement/{id}/edit', [Admincontroller::class, 'edit_advertisement'])->name('edit_advertisement');

    Route::match(['get','post'],'/products-villages-stock', [Admincontroller::class, 'products_villages_stock'])->name('products-villages-stock');
    Route::match(['get','post'],'/manage-stock-village/{villageid}', [Admincontroller::class, 'manage_stock_village'])->name('products-manage-stock');
    Route::post('/update-stock', [Admincontroller::class, 'updateStock'])->name('update.stock');

    Route::match(['get','post'],'/products', [Admincontroller::class, 'products'])->name('products')->middleware(['admin', 'check.permission:products.view']);
    Route::match(['get','post'],'/new-product', [Admincontroller::class, 'new_product'])->name('new_product');
    Route::match(['get','post'],'/edit-product/{id}', [Admincontroller::class, 'edit_product'])->name('edit_product');
    Route::match(['get','post'],'/product-status-update/{id}', [Admincontroller::class, 'product_status_update'])->name('product.status.update');
    Route::match(['get','post'],'/delete-product/{id}', [Admincontroller::class, 'delete_product'])->name('delete_product');
    Route::match(['get','post'],'/help-line', [Admincontroller::class, 'help_line'])->name('help.line')->middleware(['admin', 'check.permission:helpline.view']);
    Route::match(['get','post'],'/manage-stock/{id}', [Stockcontroller::class, 'manage_stock'])->name('product.stock.manage');
    Route::post('/manage-stock/{id}', [Stockcontroller::class, 'update_stock'])->name('product.stock.update');
    
    // settings

    Route::match(['get','post'],'/setting', [Settingcontroller::class, 'setting'])->name('setting.setting')->middleware(['admin', 'check.permission:settings.view']);
    Route::match(['get','post'],'/profile-setting', [Settingcontroller::class, 'profilesetting']);
    
    Route::post('/profile-update', [Settingcontroller::class, 'updateProfile'])->name('admin.profile.update');
    Route::post('/password-update', [Settingcontroller::class, 'updatePassword'])->name('admin.password.update');


    Route::match(['get','post'],'/roles', [Settingcontroller::class, 'roles'])->name('setting.roles');
    Route::match(['get','post'],'/delete-role/{id}', [Settingcontroller::class, 'delete_role'])->name('setting.roles.delete');
    Route::match(['get','post'],'/new-role', [Settingcontroller::class, 'new_role'])->name('setting.roles.new');
    Route::match(['get','post'],'/edit-role/{id}', [Settingcontroller::class, 'edit_role'])->name('setting.roles.edit');
    Route::match(['get','post'],'/role-permissions/{id}', [Settingcontroller::class, 'role_permissions'])->name('setting.roles.permissions');
    Route::match(['get','post'],'/admins-list', [Settingcontroller::class, 'admins_list'])->name('setting.admins_list')->middleware(['admin', 'check.permission:admins.view']);
    Route::match(['get','post'],'/supplier-list', [Settingcontroller::class, 'supplier_list'])->name('setting.supplier_list');
    Route::match(['get','post'],'/new-admin', [Settingcontroller::class, 'new_admin'])->name('setting.admins.new');
    Route::match(['get','post'],'/new-supplier', [Settingcontroller::class, 'new_supplier'])->name('setting.new-supplier');
    Route::match(['get','post'],'/edit-admin/{id}', [Settingcontroller::class, 'edit_admin'])->name('setting.admins.edit');
    Route::match(['get','post'],'/edit-supplier/{id}', [Settingcontroller::class, 'edit_supplier'])->name('setting.edit_supplier');
    Route::match(['get','post'],'/delete-admin/{id}', [Settingcontroller::class, 'delete_admin'])->name('setting.admins.delete');

    Route::match(['get','post'],'/orders-history', [Settingcontroller::class, 'ordershistory'])->name('ordershistory');
    Route::match(['get','post'],'/view-order-complaint/{orderid}', [Settingcontroller::class, 'viewordercomplaint'])->name('viewordercomplaint');
    Route::post('admin/orders/complaint/update/{orderid}', [Settingcontroller::class, 'updateComplaint'])->name('admin.update.complaint');

    Route::get('/admin/orders/view/{id}', [Settingcontroller::class, 'viewOrder']);
    Route::post('/admin/orders/update-status', [Settingcontroller::class, 'updateStatus'])->name('admin.orders.updateStatus');




});