<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
// all
Route::get('/home', 'HomeController@index')->name('home');

// for Quotation
/*Route::resource('quotation', 'QuotationController');
Route::get('export_quotation/{id}', 'QuotationController@export_quotation')->name('export_quotation');
Route::get('importExportView', 'QuotationController@importExportView');
Route::post('import', 'QuotationController@import')->name('import');*/


// access for roles
Route::group(['middleware' => ['role:level_1']], function () {
    Route::get('manager_approval', 'LevelOne@ManagerApproval')->name('manager_approval');
    Route::get('edit_levelone_approval/{id}', 'LevelOne@LevelOneApproval')->name('edit_levelone_approval');
    Route::put('update_levelone_approval/{id}', 'LevelOne@UpdateLevelOneApproval')->name('update_levelone_approval');
});

Route::group(['middleware' => ['role:lavel_2']], function () {
    Route::resource('vendor', 'VendorController');
		Route::resource('/um', 'UnitofmeasurementController');
		Route::resource('/role', 'RoleController');
		Route::resource('/category', 'ItemCategoryController');
		Route::resource('/members', 'MemberController');
		Route::resource('/location', 'LocationController');
		Route::resource('item', 'ItemController');
		Route::resource('purchase', 'PurchaseController');
		Route::POST('filter', 'ItemController@filter')->name('filter');
		Route::get('export_pdf', 'ItemController@export_pdf')->name('export_pdf');
		Route::resource('/department', 'DepartmentController');
		Route::resource('/brand', 'BrandController');
		Route::post('/purchase/fetch', 'PurchaseController@fetch')->name('fetch');
		Route::post('/purchase/updateQty', 'PurchaseController@updateQty')->name('updateQty');
		Route::get('/holdStatus', 'PurchaseController@holdStatus')->name('holdStatus');
		Route::get('invoice', 'PurchaseController@invoice')->name('invoice');
		Route::get('cartRestore', 'PurchaseController@cartRestore')->name('cartRestore');
		Route::get('generateInvoiceNumber', 'PurchaseController@generateInvoiceNumber')->name('generateInvoiceNumber');
		Route::resource('/item_purchase_history', 'ItemPurchaseHistoryController');
		Route::POST('date_filter', 'ItemPurchaseHistoryController@date_filter')->name('date_filter');
		Route::get('/unique_invoice/{id}/', 'ItemPurchaseHistoryController@show')->name('show');
		Route::get('purchase_history_pdf', 'ItemPurchaseHistoryController@purchase_history_pdf')->name('purchase_history_pdf');

		Route::get('items_approval', 'LevelTwo@LevelTwoApproval')->name('items_approval');
		Route::get('edit_leveltwo_approval/{id}', 'LevelTwo@EditLevelTwoApproval')->name('edit_leveltwo_approval');
    Route::put('update_leveltwo_approval/{id}', 'LevelTwo@UpdateLevelTwoApproval')->name('update_leveltwo_approval');
});

Route::group(['middleware' => ['role:purchase_manager']], function () {
		//
});

Route::group(['middleware' => ['role:assistant_manager|users|purchase_manager']], function () {
	Route::resource('request_for_item', 'RequestForItemController');
});

Route::group(['middleware' => ['role:assistant_manager|purchase_manager']], function () {
    Route::resource('rfq', 'RequestForQuotationController');
    Route::get('user_request', 'RequestForItemController@UsersRequest')->name('user_request');
    Route::get('user_req_status/{id}', 'RequestForItemController@UsersRequestStatus')->name('user_req_status');
    Route::put('user_req_update/{id}', 'RequestForItemController@UsersRequestUpdate')->name('user_req_update');
    Route::get('applyforquotation/{id}', 'RequestForItemController@ApplyForQuotation')->name('applyforquotation');
});

Route::group(['middleware' => ['role:users']], function () {
	//
});


/*$cat_id = 01;
$unit_id = 02;
$cat = str_pad($cat_id, 2, '0', STR_PAD_LEFT);
$unit = str_pad($unit_id, 2, '0', STR_PAD_LEFT);
$item = str_pad($cat_id, 4, '0', STR_PAD_LEFT);
echo $cat.$unit.$item;
//printf("%02d", $cat_id).printf("%02d", $unit_id).printf("%04d", $cat_id);*/