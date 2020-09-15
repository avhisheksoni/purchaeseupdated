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

Route::get('/', 'HomeController@check')->name('login');

Route::get('/login/{username}/{pass}','LoginController@login');
Route::post('/logout','LoginController@logout')->name('logout');
// Auth::routes(['register' => false]);

//Auth::routes();
// all
Route::get('/home', 'HomeController@index')->name('home');

// for Quotation

Route::get('vendor_form/{id}/{vid}', 'QuotationReceivedController@VendorRFQFormData')->name('vendor_form');
Route::post('vendorformstore/{id}/{vid}', 'QuotationReceivedController@VendorRFQFormDataStore')->name('vendorformstore');
Route::get('po_accepts/{po_id}/{vid}', 'POSendToVendorsController@POAcceptsByVendor')->name('po_accepts');
Route::post('po_accepts_data/{po_id}/{vid}', 'POSendToVendorsController@POAcceptsByVendorDataStore')->name('po_accepts_data');


/*Route::resource('quotation', 'QuotationController');
Route::get('export_quotation/{id}', 'QuotationController@export_quotation')->name('export_quotation');
Route::get('importExportView', 'QuotationController@importExportView');
Route::post('import', 'QuotationController@import')->name('import');*/


// access for roles
Route::group(['middleware' => ['role:purchase_admin']], function () {
    Route::get('manager_approval', 'LevelOne@ManagerApproval')->name('manager_approval');
    Route::get('edit_levelone_approval/{id}', 'LevelOne@LevelOneApproval')->name('edit_levelone_approval');
    Route::put('update_levelone_approval/{id}', 'LevelOne@UpdateLevelOneApproval')->name('update_levelone_approval');

    Route::get('quotation_received_levelone', 'QuotationReceivedController@QuotationReceivedAtLevelOne')->name('quotation_received_levelone');
    Route::get('qa_level_one/{id}', 'QuotationReceivedController@QuotationApprovalByLevelOne')->name('qa_level_one');
    Route::post('QuotationApprovalL1', 'QuotationReceivedController@QuotationApprovalByL1')->name('QuotationApprovalL1');
});

Route::group(['middleware' => ['role:purchase_superadmin']], function() {
    Route::resource('vendor', 'VendorController');
		Route::resource('/um', 'UnitofmeasurementController');
		Route::resource('/role', 'RoleController');
		Route::resource('/category', 'ItemCategoryController');
		Route::resource('/warehouse', 'WarehouseController');
		Route::resource('/gst_state_code', 'GSTStateCodeController');
		Route::resource('/members', 'MemberController');
		Route::resource('/location', 'LocationController');
		Route::resource('item', 'ItemController');
		Route::resource('purchase', 'PurchaseController');
		Route::POST('filter', 'ItemController@filter')->name('filter');
		Route::get('export_pdf', 'ItemController@export_pdf')->name('export_pdf');
		Route::POST('excel_import', 'ItemController@excelImportItems')->name('excel_import');
		Route::get('excel_export', 'ItemController@excelItemsExport')->name('excel_export');
		Route::get('download_sheet', 'ItemController@downloadSheetFormat')->name('download_sheet');
		Route::resource('/department', 'DepartmentController');
		Route::resource('/subcategory', 'BrandController');
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

    Route::get('quotation_received_leveltwo', 'QuotationReceivedController@QuotationReceivedAtLevelTwo')->name('quotation_received_leveltwo');
    Route::get('qa_level_two/{id}', 'QuotationReceivedController@QuotationApprovalByLevelTwo')->name('qa_level_two');
    Route::post('QuotationApprovalL2', 'QuotationReceivedController@QuotationApprovalByL2')->name('QuotationApprovalL2');

});

Route::group(['middleware' => ['role:purchase_manager']], function () {
		//
});

Route::group(['middleware' => ['role:purchase_user|purchase_manager']], function () {
	Route::resource('request_for_item', 'RequestForItemController');
	Route::post('/request_for_item/fetch', 'RequestForItemController@fetch')->name('fetch');
});

Route::group(['middleware' => ['role:purchase_manager']], function () {
    Route::resource('rfq', 'QuotationReceivedController');
    Route::get('user_request', 'RequestForItemController@UsersRequest')->name('user_request');
    Route::get('user_req_status/{id}', 'RequestForItemController@UsersRequestStatus')->name('user_req_status');
    Route::put('user_req_update/{id}', 'RequestForItemController@UsersRequestUpdate')->name('user_req_update');
    Route::get('applyforquotation/{id}', 'RequestForItemController@ApplyForQuotation')->name('applyforquotation');
    Route::post('rfiquotationtomail/{id}', 'RequestForItemController@RfiQuotationToMail')->name('rfiquotationtomail');
    Route::get('receivedQuotation/{id}', 'QuotationReceivedController@ReceivedQuotation')->name('receivedQuotation');
    Route::post('QuotationApproval', 'QuotationReceivedController@QuotationApproval')->name('QuotationApproval');
    Route::get('approval_quotation', 'QuotationReceivedController@ApprovalQuotation')->name('approval_quotation');
    Route::get('approvalQuotation_item/{id}', 'QuotationReceivedController@ApprovalQuotationItems')->name('approvalQuotation_item');
    Route::post('approvalQuotation_item_send/{id}', 'QuotationReceivedController@ApprovalQuotationItemSend')->name('approvalQuotation_item_send');



    Route::get('manager_request', 'RequestForItemController@ManagerRequest')->name('manager_request');
    Route::get('check_users_rfi/{id}', 'RequestForItemController@CheckUsersRFI')->name('check_rfi');
    Route::post('/request_for_item/set_warehouse', 'RequestForItemController@SetWareHouse')->name('set_warehouse');
});

Route::group(['middleware' => ['role:store_admin|purchase_manager|purchase_superadmin|purchase_admin']], function () {
	Route::resource('store_item', 'store_inventory\StoreItemController');
	Route::post('update_qty', 'store_inventory\StoreItemController@update_qty')->name("update_qty");
});

Route::group(['middleware' => ['role:store_admin']], function () {
	Route::resource('store_management', 'StoreManagementController');
	Route::get('view_accepted_po/{id}', 'StoreManagementController@ViewAcceptedPO')->name("view_accepted_po");
	Route::get('view_grn', 'StoreManagementController@FetchAllGRN')->name("view_grn");
	Route::get('add_grn', 'StoreManagementController@AddGRN')->name("add_grn");
});


/*$cat_id = 01;
$unit_id = 02;
$cat = str_pad($cat_id, 2, '0', STR_PAD_LEFT);
$unit = str_pad($unit_id, 2, '0', STR_PAD_LEFT);
$item = str_pad($cat_id, 4, '0', STR_PAD_LEFT);
echo $cat.$unit.$item;
//printf("%02d", $cat_id).printf("%02d", $unit_id).printf("%04d", $cat_id);*/