<?php
use Illuminate\Http\Request;
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
//    return view('welcome');
    return redirect('login');
});

Route::get('get-client','ClientController@getClient');
Route::group(['middleware' => 'auth', 'middleware' => 'expireDateCheck'],function() {
//    Route::resources([
//        'size' => 'SizeController',
//        'color' => 'ColorController',
//        'style' => 'StyleController',
//        'category' => 'CategoryController',
//        'vendor' => 'VendorController',
//        'attribute' => 'AttributeController',
//        'attribute-terms' => 'AttributeTermsController',
//        'shelf' => 'ShelfController',
//        'role' => 'RoleController',
//        //'product-draft' => 'ProductDraftController',
//        'product-variation' => 'ProductVariationController',
//        'invoice' => 'InvoiceController',
//        'invoice-product' => 'InvoiceProductVariationController'
//
//    ]);

    Route::resource('category','CategoryController')->middleware('admin:manager');
    Route::resource('vendor','VendorController')->middleware('admin');
    Route::resource('attribute','AttributeController')->middleware('admin:manager');
    Route::resource('attribute-terms','AttributeTermsController')->middleware('admin:manager');
    Route::resource('shelf','ShelfController');
    Route::resource('role','RoleController')->middleware('admin:manager');
    Route::resource('product-variation','ProductVariationController')->middleware('admin:manager');
    Route::resource('invoice','InvoiceController')->middleware('admin:manager');
    Route::resource('invoice-product','InvoiceProductVariationController')->middleware('admin:manager');
//    Route::get('defected-product-list','ProductVariationController@defectedproduct');
	Route::post('/shelf-migration','ShelfController@migration');



	Route::get('/get-variation-attributes','ProductVariationController@getAttribute');
	Route::get('/get-variation','ProductVariationController@getVariation');
	Route::post('/attribute/delete','AttributeController@delete');
	Route::post('/invoice-check','InvoiceController@invoiceCheck');
	Route::post('/get-quantity','InvoiceController@getQuantity');

    Route::get('order/list/','OrderController@index');
    Route::get('all/order/','OrderController@allOrder');
    Route::get('order/create/','OrderController@create');
	// Route::get('invoice/','InvoiceController@create');
    Route::get('completed/order/list','OrderController@completedOrderList');
    Route::get('assigned/order/list','OrderController@assignedOrderList');
    Route::get('order/list/pdf/{id}/{inv_no}','OrderController@showpage');
    Route::post('/complete/order/csv/download','OrderController@completeOrderCsvDownload');

    // Route::get('order/','OrderController@create');
	//Route::get('invoice/','InvoiceController@create');
	//Route::post('invoice/','InvoiceController@store');

    Route::get('invoice-edit/','InvoiceController@edit');
//    Route::get('invoice-view/','InvoiceController@show');
    Route::get('pending-receive','InvoiceController@show');
	Route::post('product-draft/publish/{id}','ProductDraftController@publish');
    Route::post('/product-draft/publish/{id}',[
        'as' => 'product-draft.publish',
        'uses' => 'ProductDraftController@publish'
    ]);

    Route::get('/pending-receive/edit/{id}',[
        'as' => 'pending-receive.edit',
        'uses' => 'InvoiceController@pendingReceive'
    ]);

    Route::post('/invoice-list-search',[
        'as' => 'invoice-search.search',
        'uses' => 'InvoiceController@InvoiceListSearch'
    ]);


    Route::post('vendor/add-new','VendorController@store');
    Route::get('suppliers','VendorController@index');
    Route::post('{route_name}/supplier/search','VendorController@vendorColumnSearch'); // Suppler column search
    Route::post('{route_name}/company/name/search', 'VendorController@searchSupplierCompanyName');

	//Route::get('/add-draft-product','ProductController@create');
	//Route::get('/product-draft-list','ProductController@show');
    Route::get('user/change-password/{id}','UserController@changePassword');
    Route::post('user/update-password','UserController@updatePassword');
    Route::get('/add-user','UserController@create');
    Route::post('/save-user','UserController@store');
    Route::get('/user-list','UserController@index')->middleware('admin');
    Route::get('/edit-user/{id?}','UserController@edit');
    Route::post('/update-user/{id?}','UserController@update');
    Route::get('/user-details/{id?}','UserController@show');
    Route::post('/delete-user','UserController@destroy');
    Route::post('{route_name}/user/search','UserController@userColumnsearch'); //User column search
    Route::post('{route_name}/id/name/search','UserController@userIdNamesearch'); //User id name search
    Route::get('/add-variation','VariationController@create');
    Route::get('/variation-receiving-page','VariationController@show');
    Route::get('/variation-edit','VariationController@edit');
    Route::get('/variation-details/{id?}','VariationController@variationDetails');


    Route::get('/activity-log','ActivityLogsController@index');
    Route::get('/update-list','TestController@index')->middleware('admin');
    Route::post('/update/{type}','TestController@test');
    Route::get('/activity-log/edit/{id}','ActivityLogsController@update');

    // Route::post('logout', 'Auth\MasterAppApiController@logout');
});


Route::group(['middleware' => 'expireDateCheck'],function() {
    Route::get('picked/order/list',[
        'as' => 'picked-order-list.pickedOrderList',
        'uses' => 'OrderController@pickedOrderList'
    ]);
    Route::get('complete/order/{id}',[
        'as' => 'complete-order.completeOrder',
        'uses' => 'OrderController@completeOrder'
    ]);
    //Route::get('invoice-view/','InvoiceController@show');
    Route::resources(['product-draft' => 'ProductDraftController']);
    Route::resources(['brand' => 'BrandController']);
    Route::resources(['gender' => 'GenderController']);
    Route::post('download-product-csv' , 'ProductDraftController@productVariationCsv');
    Route::post('set-authorization/{type}', 'EbayAccountController@updateAuthorization');
    Route::post('save-authorization', 'EbayAccountController@saveAuthorization');
    Route::get('authorization', 'EbayAccountController@authorrizationPage');
    Route::post('open-authorization', 'EbayAccountController@openAuthorization');
    Route::get('channel-integration/{step}','IntegrationController@index')->middleware('admin');
    ///////////////////////// start ebay
    Route::get('ebay', 'AuthController@ebay');
    Route::get('ebay-addItem', 'EbayAccountController@addItem');
    Route::get('ebay-storeItem', 'EbayAccountController@storeItem');
    Route::post('get-ebay-category', 'EbayAccountController@getCategory');
    Route::post('get-ebay-subcategory', 'EbayAccountController@getSubCategory');
    Route::post('get-account-site-data', 'EbayProfileController@getAccountSiteData');
    //Route::post('ebay-create-product', 'EbayAccountController@createEbayProduct');
    Route::get('ebay-create-account', 'EbayAccountController@createAuthorization');
    Route::post('ebay-create-account/{type}', 'EbayAccountController@storeAuthorization');
    Route::get('ebay-account-list', 'EbayAccountController@accountList');
    Route::get('ebay-edit-account/{id}', 'EbayAccountController@editAuthorization');



    Route::get('create-ebay-product/{id}/{p_id?}/{item_id?}', 'EbayMasterProductController@createMasterProduct');
    Route::post('get-profile-data', 'EbayMasterProductController@getProfile');
    Route::post('ebay-create-product', 'EbayMasterProductController@createEbayProduct');
    Route::get('ebay-master-product-list', 'EbayMasterProductController@index');
    Route::get('ebay-end-product-list', 'EbayMasterProductController@ebayEndProductList');
    Route::get('ebay-end-listings', 'EbayMasterProductController@endListing');
    Route::get('check-ebay-end-listings', 'EbayMasterProductController@checkEndedProduct');
    Route::post('relist-end-listing', 'EbayMasterProductController@relistEndItem');
    Route::get('ebay-master-product-with-error-message-list', 'EbayMasterProductController@masterProductWithErrorMessage');
    Route::get('ebay-pending-list', 'EbayMasterProductController@pendingListing');
    Route::get('ebay-master-product/{id}/edit', 'EbayMasterProductController@edit');
    Route::post('ebay-master-product-revise', 'EbayMasterProductController@reviseProduct');
    Route::get('ebay-delete-listing/{id}/{itemId}', 'EbayMasterProductController@destroy');
    Route::get('ebay-delete-variation/{id}/{sku}', 'EbayMasterProductController@destroyVariation');
    Route::get('ebay-master-product/{id}/view', 'EbayMasterProductController@show');
    Route::get('ebay-profile/{id}/duplicate', 'EbayProfileController@duplicateProfile');
    Route::post('{route_name}/profile/search','EbayProfileController@ebayProfileNameSearch'); //ebay profile search
    Route::post('quantity-sync','EbayMasterProductController@QuantitySync'); //ebay profile search
    Route::post('permanent-delete','EbayMasterProductController@ebayPermanentDelete'); //ebay profile search
    Route::post('end-product','EbayMasterProductController@endProduct'); //ebay profile search
    Route::post('check-ebay-product-quantity','EbayMasterProductController@productCSV'); //ebay profile search
    Route::put('ebay-product-update/{id}', 'EbayMasterProductController@update');
    Route::get('ebay-variation-product-delete/{id}/{sku}', 'EbayMasterProductController@deleteVariation');
    Route::get('ebay-revise-product-list', 'EbayMasterProductController@reviseList');


    Route::post('ebay-update-account/{id}', 'EbayAccountController@updateEbayAuthorization');
    Route::post('delete-ebay-account/{id}', 'EbayAccountController@deleteEbayAccount');
    Route::get('ebay-campaign-migration/{id}', 'EbayAccountSyncController@campaignMigration');
    Route::get('ebay-sync-account/{id}/{type}', 'EbayAccountSyncController@authorizeEbay');
    Route::get('ebay-get-total-count/{id}', 'EbayAccountSyncController@getTotalCount');
    Route::get('ebay-get-count/{id}', 'EbayAccountSyncController@getTotalCount');
    Route::post('set-default-policy', 'EbayAccountSyncController@setDefaultPolicy');
    Route::get('get-policy/{id}', 'EbayAccountSyncController@getPolicy');
    Route::get('ebay-get-item/{id}/{pageNumber}', 'EbayAccountSyncController@getItem');
    Route::get('check-template/{template}/{id}', 'EbayMasterProductController@checkTemplate');
    Route::resources(['return-policy' => 'ReturnPolicyController']);
    Route::resources(['shipment-policy' => 'ShipmentPolicyController']);
    Route::resources(['payment-policy' => 'PaymentPolicyController']);
    Route::resources(['ebay-profile' => 'EbayProfileController']);
    Route::resources(['ebay-paypal' => 'EbayPaypalAccountController']);
    Route::resources(['ebay-template' => 'EbayTemplateController']);
    /////////////////////////// end ebay
    Route::post('order-create-webhooks','OrderController@orderCreateWebhooks');

    Route::post('picker-assign','OrderController@assignPicker');
    Route::post('/invoice/number','InvoiceController@getInvoiceNumber');
    Route::post('/get-vendor','InvoiceController@getVendor');
    Route::get('firebase', 'FirebaseController@index');


    Route::post('order-search','OrderController@OrderSearch');

    Route::get('choose-return-product/{id}','OrderController@chooseReturnProduct');
    Route::post('save-return-order','OrderController@saveReturnOrder');
    Route::get('return/order/list','OrderController@returnOrderList');
    Route::get('vendor-product-list/{id}','VendorController@verdorProductList');
    Route::post('indivisual-vendor-invoice-search','VendorController@indivisualVendorInvoiceSearch');
    Route::get('get-return-order-product-sku','OrderController@getReturnOrderProductSKU');
    Route::get('reshelved-product-list','ShelfController@reshelvedProductList');
    Route::get('defected-product-list','InvoiceProductVariationController@defectedProductList');
    Route::any('defect-reason/{type}/{action}/{id?}','InvoiceProductVariationController@defectReasonAction');
    Route::any('defect-action/{type}/{action}/{id?}','InvoiceProductVariationController@defectProductAction');
    Route::post('sell-defected-product-ajax','InvoiceProductVariationController@sellDefectedProduct');
    Route::get('print-barcode/{id}','InvoiceController@printBarcode');
    Route::get('print-bulk-barcode/{id}','InvoiceController@printBulkBarcode');
    Route::get('print-shelf-barcode/{id}','ShelfController@printShelfBarcode');
    Route::get('manual-order/{orderId?}/{type?}','OrderController@manualOrder');
    Route::post('get-all-variation-by-product-draft-ajax','OrderController@getAllVariationByProductDraftAjax');
    Route::post('manual-order-save-ajax','OrderController@manualOrderSaveAjax');
    Route::get('sync-order-from-woocommerce','OrderController@syncOrderFromWoocommerce');
    Route::get('corn-sync-order-from-woocommerce','WoocomOrderSyncController@syncOrderFromWoocommerce');
    Route::get('sync-order-from-woocommerce-clicked','WoocomOrderSyncController@syncOrderFromWoocommerceClicked');

    Route::get('manual-order-list','OrderController@manualOrderList');
    Route::get('published-product','ProductDraftController@publishedProductList');
    Route::get('notification-page','NotificationPageController@index');

    Route::get('manual-order-update','OrderController@manualOrderUpdate');
    Route::post('search-product-list','ProductDraftController@searchProductList');
    Route::post('search-variation-list','ProductVariationController@searchVariationList');
    Route::post('bulk-complete-order','OrderController@bulkCompleteOrder');
    Route::resource('app-url-setting','UrlController');
    Route::post('exist-ean-no-check','ProductVariationController@exitEanNoCheck');
    Route::get('exchange-order-product/{id?}','OrderController@exchangeOrderProduct');
    Route::post('save-exchange-order-product','OrderController@saveExchangeOrderProduct');
    Route::post('bulk-shelver-change','InvoiceController@bulkShelverChange');
    Route::get('hold-assigned-order/{id}','OrderController@holdAssignedOrder');
    Route::get('hold/order/list','OrderController@holdOrderList');
    Route::get('add-additional-terms-draft/{id}','ProductDraftController@addAdditionalTermsDraft');
    Route::get('add-additional-terms-draft-{id}','ProductDraftController@addAdditionalTermsCatalogue');
    Route::post('save-additional-terms-draft','ProductDraftController@saveAdditionalTermsDraft');
    Route::get('duplicate-draft-catalogue/{id}','ProductDraftController@duplicateDraftCatalogue');
    Route::get('group-order','OrderController@groupOrderList');
    Route::post('ajax-shelf-wise-product-list','OrderController@ajaxShelfWiseProductList');
    Route::get('low-quantity-product-list/{visible?}','ProductVariationController@lowQuantityProductList');
    Route::post('get-product-price-ajax','InvoiceController@getProductPriceAjax');
    Route::get('catalogue/{id}/product','ProductVariationController@catalogueProduct');
    Route::get('create-ebay-product-variation/{id}/{sku}', 'ProductVariationController@addVariationOnEbay');
    Route::get('variation-edit/{id}', 'EbayMasterProductController@variationEdit');
    Route::post('multiple-product-add','ProductVariationController@multipleProductAdd');
    Route::get('catalogue-product-invoice-receive/{id}/{varid?}/{type?}/{return_id?}/{variationId?}','InvoiceController@catalogueProductInvoiceReceive');
    Route::post('save-catalogue-product-invoice-receive','InvoiceController@saveCatalogueProductInvoiceReceive');
    Route::get('browse-category','OnbuyController@browseCategory');
    Route::post('search-catalogue-by-date','ProductDraftController@searchCatalogueByDate');
    Route::post('get-variation','ProductDraftController@getVariation');
    Route::post('get-ebay-variation','EbayMasterProductController@getVariation');
    Route::post('update-ebay-variation/{id}','EbayMasterProductController@variationUpdate');
    Route::post('verify-ebay-product/{profileId?}','EbayMasterProductController@verifyEbayProduct');
    Route::get('unmatched-inventory-list','ProductVariationController@unmatchedInventoryList');
    Route::post('shelve-return-product','OrderController@shelveReturnProduct');
    Route::post('search-threshold-unmatched-product','ProductVariationController@searchThresholdUnmatchedProduct');
    Route::resource('return-reason','ReturnReasonController');
    Route::post('shelf_quantity_update','ShelfController@shelfQuantityUpdate');
    Route::post('complete-order-general-search','OrderController@completeOrderGeneralSearch');
    Route::post('get-scanning-sku-result', 'OrderController@getScanningSkuResult');
    Route::get('change-shelf-quantity-log','ShelfController@changeShelfQuantityLog');
    Route::get('delete-change-shelf-quantity-log/{id}','ShelfController@deleteChangeShelfQuantityLog');
    Route::post('add-order-note','OrderController@addOrderNote');
    Route::post('view-order-note','OrderController@viewOrderNote');
    Route::post('unread','OrderController@unread');
    Route::post('update-order-note','OrderController@updateOrderNote');
    Route::post('delete-order-note','OrderController@deleteOrderNote');
    Route::get('add-product-empty-order/{id}','OrderController@addProductEmptyOrder');
    Route::post('download-product-csv' , 'ProductDraftController@productVariationCsv');
    Route::post('save-product-empty-order','OrderController@saveProductEmptyOrder');
    Route::post('save-setting','SettingController@saveSetting');
    Route::get('shipping-setting','SettingController@shippingFee');
    Route::post('shipping-data-input','SettingController@storeShippingFee');
    Route::resource('settings','SettingController')->middleware('admin');
    Route::get('sync-order-from-ebay-clicked/{type?}','EbayOrderSyncController@syncOrderFromEbayClicked');
    Route::post('get-onbuy-variation','OnbuyController@getVariation');
});



Route::group(['prefix' => 'onbuy', 'middleware' => ['expireDateCheck','onbuy']],function (){
    Route::get('create-product/{id}','OnbuyController@createProduct');
    Route::get('create-profile','OnbuyController@createProfile');
    Route::get('edit-profile/{id}','OnbuyController@editProfile');
    Route::get('profile-list','OnbuyController@profileList');
    Route::post('save-onbuy-product','OnbuyController@saveOnbuyProduct');
    Route::post('save-onbuy-profile','OnbuyController@saveProfile');
    Route::put('update-onbuy-profile/{id}','OnbuyController@updateProfile');
    Route::delete('delete-onbuy-profile/{id}','OnbuyController@deleteProfile');
    Route::get('master-product-list','OnbuyController@masterProductList');
    Route::post('create-ajax-page','OnbuyController@createAjaxPage');


    Route::get('master-product-details/{opc}','OnbuyController@masterProductDetails');
    //Route::get('fetch-onbuy-order','OnbuyController@fetchOnbuyOrder');
    Route::post('ajax-category-child-list','OnbuyController@ajaxCategoryChildList');
    Route::get('sync-order-from-onbuy','OnbuyController@syncOrderFromOnbuy');
    Route::get('corn-sync-order-from-onbuy','OnbuyOrderSyncController@syncOrderFromOnbuy');
    Route::get('sync-order-from-onbuy-clicked','OnbuyOrderSyncController@syncOrderFromOnbuyClicked');


    Route::get('master-product-details/{id}','OnbuyController@masterProductDetails');
    Route::get('fetch-onbuy-order','OnbuyController@fetchOnbuyOrder');
    Route::post('ajax-profile-category-child-list','OnbuyController@ajaxProfileCategoryChildList');
    Route::post('check-queue-id','OnbuyController@checkQueueId');
    Route::get('variation-product-details/{id}','OnbuyController@variationProductDetails');
    Route::get('variation-product-details/{id}','OnbuyController@variationProductDetails');
    Route::get('edit-master-product/{id}','OnbuyController@editMasterProduct');
    Route::post('update-master-product/{id}','OnbuyController@updateMasterProduct');
    Route::get('edit-variation-product/{id}','OnbuyController@editVariationProduct');
    Route::post('update-variation-product/{id}','OnbuyController@updateVariationProduct');
    Route::get('duplicate-master-product/{id}','OnbuyController@duplicateMasterProduct');
    Route::post('save-duplicate-master-product/{id}','OnbuyController@saveDuplicateMasterProduct');
    Route::get('add-listing/{id}','OnbuyController@addListing');
    Route::post('save-listings/{id}','OnbuyController@saveListings');
    Route::get('delete-listing/{id}/{lid?}','OnbuyController@deleteListing');
    Route::post('search-profile','OnbuyController@searchProfile');
    Route::get('duplicate-profile/{id}','OnbuyController@duplicateProfile');
    Route::post('save-duplicate-profile','OnbuyController@saveDuplicateProfile');
    Route::post('search-product-list','OnbuyController@searchProductList');
    Route::get('pending-catalogue-listing/{ean}','OnbuyController@pendingCatalogueListing');
    Route::get('account-credentials','OnbuyController@accountCredentials');
    // Route::post('create-account','OnbuyController@onbuyCreateAccount');
    Route::post('update-account/{id}','OnbuyController@updateAccount');
    Route::get('queue-id-bulk-check','OnbuyController@queueIdBulkCheck');
    Route::get('failed-catalogue-list','OnbuyController@failedCatalogueList');
    Route::get('add-exist-ean-listing/','OnbuyController@addExistEanListing');
    Route::post('save-exist-ean-listings','OnbuyController@saveExistEanListing');
    Route::get('category','OnbuyController@category');
    Route::post('category-migrate','OnbuyController@categoryMigrate');
    Route::get('brand','OnbuyController@brand');
    Route::post('pull-matched-brand','OnbuyController@pullMatchedBrand');
    Route::post('save-brand','OnbuyController@saveBrand');
    Route::post('bulk-sale-price-boost-commission','OnbuyController@bulkSalePriceBoostCommission');
    Route::get('lead-listing-check','OnbuyController@leadListingCheck');
    Route::post('search-lead-listing-product','OnbuyController@searchLeadListingProduct');
    Route::post('make-lead-listing','OnbuyController@makeLeadListing');
    Route::get('search-product','OnbuyController@searchOnOnbuy');
    Route::post('search-product-on-onbuy','OnbuyController@searchProductOnOnbuy');

});
Route::post('onbuy/create-account','OnbuyController@onbuyCreateAccount');

Route::group(['prefix' => 'woocommerce', 'middleware' => ['expireDateCheck','woocommerce']],function(){
    Route::get('catalogue/create/{m_c_id?}','woocommerce\WoocommerceCatalogueController@create');
    Route::post('catalogue/store','woocommerce\WoocommerceCatalogueController@store');
    Route::get('{type}/catalogue/list','woocommerce\WoocommerceCatalogueController@index');
    // Route::get('softdelete-all-variation', 'woocommerce\WoocommerceCatalogueController@softdeleteMultipleWooVariation');
    Route::post('get-variation','woocommerce\WoocommerceCatalogueController@getVariation');
    Route::get('catalogue/{id?}/variation','woocommerce\WoocommerceVariationController@cataloguevariation');
    Route::post('variation/create','woocommerce\WoocommerceVariationController@variationCreate');
    Route::post('search-catalogue-list','woocommerce\WoocommerceCatalogueController@searchCatalogueList');
    Route::get('{type}/catalogue/{id}/edit','woocommerce\WoocommerceCatalogueController@edit');
    Route::post('catalogue/update/{id}','woocommerce\WoocommerceCatalogueController@update');
    Route::get('{type}/catalogue/{id}/show','woocommerce\WoocommerceCatalogueController@show');
    Route::get('duplicate-catalogue/{id}','woocommerce\WoocommerceCatalogueController@duplicateCatalogue');
    Route::post('catalogue/publish/{id}','woocommerce\WoocommerceCatalogueController@publishCatalogue');
    Route::post('catalogue/delete/{id}','woocommerce\WoocommerceCatalogueController@destroy');
    Route::get('variation/{id}/edit','woocommerce\WoocommerceVariationController@edit');
    Route::post('variation/update/{id}','woocommerce\WoocommerceVariationController@update');
    Route::get('variation/details/{id}','woocommerce\WoocommerceVariationController@show');
    Route::post('variation/delete/{id}','woocommerce\WoocommerceVariationController@destroy');
    Route::get('variation/list','woocommerce\WoocommerceVariationController@index');
    Route::post('upload-csv','woocommerce\WoocommerceCatalogueController@uploadCsv');
    Route::post('search-catalogue-by-date','woocommerce\WoocommerceCatalogueController@woocommeerceSearchCatalogueByDate');
    Route::get('pending/catalogue/lists','woocommerce\WoocommerceCatalogueController@pendingCatalogueList');
    Route::get('account-credentials','woocommerce\WoocommerceCatalogueController@accountCredentials');
    // Route::post('create-account','woocommerce\WoocommerceCatalogueController@woocommerceCreateAccount');
    Route::post('update-account/{id}','woocommerce\WoocommerceCatalogueController@updateAccount');
    Route::post('bulk-draft-catalogue-complete','woocommerce\WoocommerceCatalogueController@bulkDraftCatalogueComplete');
    Route::post('active-catalogue-bulk-delete','woocommerce\WoocommerceCatalogueController@activeCatalogueBulkDelete');
    Route::get('edit-attribute-term/{id}','woocommerce\WoocommerceCatalogueController@editAttributeTerm');
    Route::post('update-attribute-term','woocommerce\WoocommerceCatalogueController@updateAttributeTerm');
    Route::post('delete-attribute-term','woocommerce\WoocommerceCatalogueController@deleteAttributeTerm');
    Route::post('add-attribute-term','woocommerce\WoocommerceCatalogueController@addAttributeTerm');
});
Route::post('woocommerce/create-account','woocommerce\WoocommerceCatalogueController@woocommerceCreateAccount');


Route::group(['middleware' => 'expireDateCheck'],function(){
    Route::get('pos-order','OrderController@posOrder');
    Route::post('pos-order-product-search','OrderController@posProductSearch');
    Route::post('create-pos-order','OrderController@createPosOrder');
    Route::post('upload-csv','ProductDraftController@uploadCSV');
    Route::get('channel-sale','DashboardController@channelSale');
    Route::post('variation-price-bulk-update','ProductVariationController@variationPriceBulkUpdate');
    Route::post('pagination-all',function (Request $request){
        $query = $request->query_params ? $request->query_params : '';
        return redirect(url($request->route_name.'?page='.$request->paged.$query));
    });
    Route::get('pagination-not-all',function (Request $request){
        $route_name = str_replace("page=1","page=".$request->paged,$request->first_page_url);

        return redirect($route_name);
    });
    Route::resource('woowms-category','WooWmsCategoryController');
    Route::resource('condition','ConditionController');
    Route::post('make-default-condition','ConditionController@makeDefaultCondition');
    Route::get('{route_name}/cancel-order/{id}','OrderController@cancelOrder');
    Route::post('{route_name}/catalogue/search','ProductDraftController@columnSearch');
    Route::post('{route_name}/search','ProductVariationController@columnSearch'); // Catalogue low quantity column search
    Route::post('{route_name}/woocommerce/catalogue/search', 'woocommerce\WoocommerceCatalogueController@WooCommerceActiveDraftProductColumnSearch'); //WooCommerce active draft product column search
    Route::post('{route_name}/pending/catalogue/search', 'woocommerce\WoocommerceCatalogueController@wooCommercePendingColumnSearch');
    Route::post('OnBuy/active/product/search', 'OnbuyController@onbuyMasterProductSearch'); //OnBuy active product column search
    Route::post('{route_name}/{ean}/product/list/search', 'OnbuyController@pendingMissingEanWithoutEanProductSearch'); //OnBuy active product column search
    Route::get('eBay/active/product/search', 'EbayMasterProductController@eBayActiveProductSearch'); //eBay active product column search
    Route::get('eBay/end/product/search', 'EbayMasterProductController@eBayEndProductSearch'); //eBay active product column search
    Route::get('eBay/pending/product/search', 'EbayMasterProductController@eBayPendingProductSearch'); //eBay pending product column search
    Route::get('eBay/revise/product/search', 'EbayMasterProductController@reviseListColumnSearch'); //eBay revise product column search
    Route::post('ebay-ended-product-check/{type?}', 'EbayMasterProductController@checkSingleEndedProduct'); //eBay revise product column search
    Route::post('invoice/history/column/search', 'InvoiceController@invoiceHistorySearch'); // Invoice history column search
    Route::post('invoice/number/search', 'InvoiceController@invoiceNoSKUSearch'); // Invoice history invoice number search
    Route::post('invoice/pending/receive/search', 'InvoiceController@pendingReceiveInvoiceNo');
    Route::any('attribute/terms/search', 'AttributeTermsController@attributeTermsSearch');
    Route::any('manage-variation-sku-validation', 'ProductVariationController@manage_variation_sku_validation');
    Route::post('column-search',function (Request $request){  //Shelf column search
    //echo '<pre>';
    //print_r($request->all());
    //exit();
        $url = '';
        foreach ($request->all() as $key => $value){
            if($key != '_token' && $key != 'route_name' && $request[$key] != null){
                $url .= $key.'='.$value.'&';
            }
        }
        $formated_url = 'is_search=true&'.rtrim($url,'&');
        return redirect(url($request->route_name.'?'.$formated_url));
    });
    Route::post('sales-by-date','DashboardController@salesByDate');
    Route::post('sales-by-channel','DashboardController@salesByChannel');
    Route::post('top-ordered-country','DashboardController@topOrderedCountry');
    Route::post('top-ordered-product','DashboardController@topOrderedProduct');
    Route::post('top-ordered-category','DashboardController@topOrderedCategory');
    Route::get('draft-catalogue-list','ProductDraftController@draftCatalogueList');
    Route::get('completed-catalogue-list','ProductDraftController@index');
    Route::get('trash','ProductDraftController@trash');
    Route::post('draft-make-complete','ProductDraftController@draftMakeComplete');
    Route::get('woocomm-processing-order','ProductDraftController@woocommProcessingOrder');
    Route::post('gender-category','ProductDraftController@genderCategory');
    Route::post('add-product-draft-value','ProductDraftController@addProductDraftValue');
    Route::post('get-terms-information','AttributeTermsController@getTermsInformation');
    Route::post('save-variation-image-attribute-wise','ProductVariationController@saveVariationImageAttributeWise');
    Route::post('cancel-order-product-sync','OrderController@cancelOrderProductSync');
    Route::post('ebay-master-product-search','EbayMasterProductController@ebayMasterProductSearch'); // eBay master product column search
    Route::get('cancelled/order/list','OrderController@cancelledOrderList');
    Route::post('shelf-search','ShelfController@shelfSearch');
    Route::post('delete-shelf','ShelfController@deleteShelf');
    Route::get('shelf-use-setting/{shelfStatus}','SettingController@shelfSetting');
    Route::post('reshelved-product-search', 'ShelfController@reshelvedProductSearch'); // Reshelved product shelf & sku search
    Route::post('shelf-qty-change-log-search', 'ShelfController@shelfQtyChangeLogProductSearch'); // Shelf quantity change log  shelf search
    Route::get('complete-postcode-order/{postcode}','OrderController@complePostCodeOrder');
    Route::resource('client','ClientController');
    Route::post('client/{id}','ClientController@update');
    Route::post('bulk-draft-catalogue-complete','ProductDraftController@bulkDraftCatalgueComplete');
    Route::get('unhold-order/{orderId}','OrderController@unholdOrder');
    Route::get('hide-low-quantity-product/{id}','ProductVariationController@hideLowQuantityProduct');
    Route::post('shelf-available-bulk-sync','ProductVariationController@shelfAvailableBulkSync');
    Route::get('delete-order-product/{orderId}/{productId?}/{shelfId?}','OrderController@deleteOrderProduct');
    Route::get('get-picked-product/{id}','OrderController@getPickedProduct');
    Route::post('master-catalgue-bulk-delete','ProductDraftController@masterCatalogueBulkDelete');
    Route::post('master-catalgue-bulk-restore','ProductDraftController@masterCatalogueBulkRestore');
    Route::post('shelf-quantity-change-reason','ShelfController@shelfQuantityChangeReason');
    Route::get('attribute-as-variation-modify/{attributeId}/{value}','AttributeController@attributeAsVariationModify');
    Route::post('master-catalogue-exist-check','ProductDraftController@masterCatalogueExistCheck');
    Route::get('order-cancel-reason','OrderController@orderCancelReason');
    Route::post('add-order-cancel-reason','OrderController@addOrderCancelReason');
    Route::post('update-order-cancel-reason','OrderController@updateOrderCancelReason');
    Route::post('delete-order-cancel-reason','OrderController@deleteOrderCancelReason');
    Route::get('available-quantity-change-log','ProductVariationController@availableQuantityChangeLog');
    Route::post('validate-upload-order-product-csv','OrderController@validateUploadOrderProductCSV');
    Route::post('get-attribute-terms','AttributeTermsController@getAttributeTerms');
    Route::post('variation-bulk-delete','ProductVariationController@variationBulkDelete');
    Route::get('change-low-quantity/{id}','ProductVariationController@changeLowQuantity');
    Route::post('variation-declare-defect','ProductVariationController@variationDeclareDefect');
    Route::get('get-defected-reason/{id}','ProductVariationController@getDefectedReason');
    // Route::any('defect-reason/{type}/{action}/{id?}','ProductVariationController@defectReasonAction');
    // Route::any('defect-action/{type}/{action}/{id?}','ProductVariationController@defectProductAction');
    Route::get('change-defect-product-status/{productId}/{reasonId}','ProductVariationController@changeDefectProductStatus');
    Route::post('download-declare-defect-csv','ProductVariationController@downloadDeclareDefectCsv');
    Route::get('create-ebay-profile/{site_id}/{account_id}/{category_id}','EbayProfileController@createEbayProfile');
    Route::post('ebay-migration-profile-count','EbayProfileController@ebayMigrationProfileCount');
    Route::post('variation-modified','ProductVariationController@variationModified');
    Route::post('group-catalogue-picker-assign','OrderController@groupCataloguePickerAssign');
});

//Amazon Routes Start
Route::group(['prefix' => 'amazon', 'middleware' => ['expireDateCheck','amazon']],function(){
    Route::get('account-authorization','AmazonController@accountAuthorization');
    Route::get('set-application-session-value/{appId}','AmazonController@getApplicationSessionValue');
    Route::get('accounts','AmazonController@accountList');
    Route::get('single-account-info/{id}','AmazonController@singleAccountInfo');
    // Route::post('save-account','AmazonController@saveAccount');
    Route::post('update-account','AmazonController@updateAccount');
    Route::post('delete-account','AmazonController@deleteAccount');
    Route::get('applications','AmazonController@applications');
    Route::get('add-application','AmazonController@addApplication');
    // Route::post('save-application','AmazonController@saveApplication');
    Route::get('edit-application/{id}','AmazonController@editApplication');
    Route::post('update-application/{id}','AmazonController@updateApplication');
    Route::post('delete-application','AmazonController@deleteApplication');
    Route::get('active-catalogues','AmazonController@activeCatalogues');
    Route::get('pending-catalogue','AmazonController@pendingCatalogue');
    Route::post('get-pending-master-variation','AmazonController@getPendingMasterVariation');
    Route::get('create-amazon-product/{catalogueId}','AmazonController@createAmazonProduct');
    Route::post('exist-product-check','AmazonController@existProductCheck');
    Route::post('save-amazon-product','AmazonController@saveAmazonProduct');
    Route::post('update-variation','AmazonController@updateVariation');
    Route::post('delete-variation','AmazonController@deleteVariation');
    Route::post('delete-catalogue','AmazonController@deleteCatalogue');
    Route::post('save-single-amazon-product','AmazonController@saveSingleAmazonProduct');
    Route::post('migrate-product-type','AmazonController@migrateProductType');
    Route::get('seller-sites','AmazonController@sellerSites');
    Route::post('migrate-seller-sites','AmazonController@migrateSellerSites');
    Route::get('all-account-info','AmazonController@allAccountInfo');
    Route::get('order-sync/{orderType?}','AmazonController@orderSync');
    //Create Amazon Master Catalogue With All Details Routes
    Route::get('create-amazon-master-catalogue','AmazonController@createAmazonMasterCatalogue');
    Route::get('amazon-credentials','AmazonController@amazonCredentials');
    Route::get('aws-signature','AmazonController@awsSignature');
    Route::get('amz-test-order','AmazonController@amzTestOrder');
    Route::get('amazon-authorization','AmazonController@amazonAuthorization');
    Route::get('amazon-access-token','AmazonController@amazonAccessToken');
    Route::get('amazon-get-data','AmazonController@amazonGetData');
    Route::get('amazon-credentials','AmazonController@amazon');
    Route::get('amazon-data','AmazonController@amazon');
    Route::get('read-buyer-message/{orderId}','OrderController@readBuyerMessage');

    //Amazon Routes End

});
Route::post('amazon/save-account','AmazonController@saveAccount');
Route::post('amazon/save-application','AmazonController@saveApplication');

Route::group(['middleware' => 'expireDateCheck'],function(){
    Route::post('all-column-search',function(Request $request){
        // dd($request->all());
        $url = '';
        foreach ($request->all() as $key => $value){
            if($key != '_token' && $key != 'search_route' && $request[$key] != null && $key != 'is_search'){
                if(is_array($value)){
                    // dd($value);
                    $arrVal = '';
                    foreach($value as $val){
                        $arrVal .= str_replace('&','wms-and',$val).'+~';
                    }
                    $value = rtrim($arrVal, '+~');
                }
                $url .= $key.'='.str_replace('&','wms-and',$value).'&';
            }
        }
        // $formated_url = rtrim($url,'&');
        $formated_url = 'is_search=true&'.rtrim($url,'&');
        // return url($request->search_route.'?'.$formated_url);
        return redirect(url($request->search_route.'?'.$formated_url));
    });

    Route::get('404',function(){
        $notFound = view('404');
        return view('master',compact('notFound'));
    });
    Route::get('exception', function (){
        $exception = view('exception');
        return view('master',compact('exception'));
    });

    //Master catalogue id copy to master sku short code start
    Route::get('parent-sku-sent-to-woocommerce','woocommerce\WoocommerceCatalogueController@parentSkuSentToWoocommerce');
    //Master catalogue id copy to master sku short code start


    // Dynamic attribute migration start
    Route::get('attribute-new-formate','ProductDraftController@attributeNewFormate');

    Route::get('ebay-migration-list','MigrationController@ebayMigration');
    Route::get('ebay-migration-started-integration/{account_id}','MigrationController@migrationStartedFromIntegration');
    Route::get('ebay-migration-started/{type}','MigrationController@migrationStarted');
    Route::get('ebay-description-migration','MigrationController@descriptionMigration');
    Route::get('ebay-migration-without-variation-started','MigrationController@onlyDraftProduct');
    Route::post('ebay-migration-cat-page/ac_id','MigrationController@migrationCategoryPage');
    Route::get('auto-create-profile/{id}','MigrationController@autoCreateProfile');
    //Route::get('ebay-migration-campaign','MigrationController@campaignMigration');

    // Dynamic attribute migration end

    // Woocommerce Migration Start


    Route::get('woocommerce-attribute-list','WoocommerceMigrationController@woocommerceAttributeList');
    Route::get('woocommerce-attribute-terms-list','WoocommerceMigrationController@woocommerceTermsAttributeList');
    Route::get('woocommerce-as-master-catalogue','WoocommerceMigrationController@woocommerceAsMasterCatalogue');
    Route::get('woocommerce-as-master-variation','WoocommerceMigrationController@woocommerceAsMasterVariation');
    Route::get('woocommerce-catalogue','WoocommerceMigrationController@woocommerceCatalogue');
    Route::get('woocommerce-variation','WoocommerceMigrationController@woocommerceVariation');
    Route::get('woocommerce-single-attribute','WoocommerceMigrationController@woocommerceSingleAttribute');
    Route::get('woocommerce-choose-migration','WoocommerceMigrationController@woocommerceChooseMigration');
    Route::post('woocommerce-save-attribute-migration','WoocommerceMigrationController@woocommerSaveAttributeMigration');

    // Woocommerce Migration End

    Route::get('/home', 'HomeController@index')->name('home');
    //////////////////////////////////////test controller
    Route::get('/test-order', 'EbayOrderSyncController@test');
    Route::get('/check-campaign', 'EbayMasterProductController@checkCampaign');
    //Route::get('/web-check', 'EbayMasterProductController@WebCheck');

    /////////////////////////////////////////// invoice settings route
    Route::get('invoice-setting','SettingController@invoiceSetting');
    Route::post('invoice-setting-form','SettingController@invoiceSettingSave');

    Route::get('auto-sync-button','SettingController@autoSyncButton');
    Route::get('item-specifics-sync','MigrationController@syncEndedProduct');
    Route::post('auto-sync-button-setting','SettingController@autoSyncButtonSave');

    Route::get('amazon-authorization','EbayAccountController@amazon');
    Route::get('sync-available','ShelfController@availableAndShelfEqual');
    Route::post('test-command','EbayAccountController@testCommand');

    // shopify controller route
    Route::get('shopify-api-test','ShopifyController@shopifyApiTest');
    Route::get('shopify/catalogue/create/{id?}','ShopifyController@create');
    Route::get('shopify/variation/create/{id?}','ShopifyController@createVariation');
    Route::post('shopify/catalogue/store','ShopifyController@store');
    Route::get('shopify/accounts','Shopify\AccountController@accountList');



    Route::get('shopify/collection','Shopify\ShopifyCollectionController@collectionList');
    Route::post('shopify/collection/add','Shopify\ShopifyCollectionController@collectionAdd');
    Route::post('shopify/collection/edit/{id}','Shopify\ShopifyCollectionController@edit');
    Route::post('shopify/collection/delete/{id}','Shopify\ShopifyCollectionController@delete');
    Route::post('shopify/collection/migration','Shopify\ShopifyCollectionController@migration');

    Route::get('shopify/tags','Shopify\TagController@tagsList');
    Route::post('shopify/tag/add','Shopify\TagController@create');
    Route::post('shopify/tag/edit/{id}','Shopify\TagController@edit');
    Route::post('shopify/tag/delete/{id}','Shopify\TagController@delete');


    Route::post('shopify-create-account','Shopify\AccountController@createAccount');
    Route::post('shopify/shopify-edit-account/{id}','Shopify\AccountController@editAccount');
    Route::post('shopify/shopify-delete-account/{id}','Shopify\AccountController@accountDelete');
    Route::get('shopify/shopify-master-product-list','ShopifyController@activeCatalogues');
    Route::get('shopify/shopify-pending-list','ShopifyController@pendingCatalogue');
    Route::get('shopify/draft-product-list','ShopifyController@draftCatalogues');
    Route::post('shopify/get-shopify-variation','ShopifyController@getVariation');
    Route::post('shopify/catalogue/update/{id}','ShopifyController@update');
    Route::get('shopify/catalogue/active/{id}','ShopifyController@makeActiveCatalogue');
    Route::get('shopify/product-delete/{id}','ShopifyController@productDelete');

    Route::get('shopify/order-details','Shopify\OrderController@shopifyOrder');
    Route::get('shopify/show/{id}/view','ShopifyController@show');
    Route::get('shopify/catalogue/{id}/edit','ShopifyController@edit');
    Route::get('shopify/product_sync/{id}','ShopifyController@productSync');

});

// mobile app route
Route::get('wms/app/download', 'AppDownloadController@download');
Route::post('filter-order-export-csv','OrderController@filterOrderExportCsv');
Route::get('reports','ProductDraftController@reports');
Route::post('export-catalogue-csv','ProductDraftController@exportCatalogueCsv');

Route::post('get-catalog', 'ProductDraftController@getCatalogue');
Route::get('master-attribute-migrate-to-woocommerce','WoocommerceMigrationController@masterAttributeMigrateToWoocommerce');
Route::get('item-attribute','ProductDraftController@itemAttribute');
Route::post('save-item-attribute','ProductDraftController@saveItemAttribute');
Route::post('edit-item-term','ProductDraftController@editItemTerm');
Route::post('delete-item-term','ProductDraftController@deleteItemTerm');
Route::resource('channels','ChannelController')->middleware('admin');
Route::post('save-mapping-item-term','ProductDraftController@saveMappingItemTerm');
Route::post('channel-map-field','ChannelController@channelMapField');
Route::post('get-mapping-field','ProductDraftController@getMappingField');
Route::post('modify-mapping-field','ProductDraftController@modifyMappingField');
Route::get('wms-category','CategoryController@getWmsCategory');
Route::post('update-item-attribute','ProductDraftController@updateItemAttribute');
Route::get('remove-domain-from-url','ProductDraftController@removeDomainFromUrl');
Route::post('create-royal-mail-order','OrderController@createRoyalMailOrder');
Route::post('channels/change-channel-statue','ChannelController@changeChannelStatue');
Route::get('get-item-attribute-term/{attrId}','ProductDraftController@getItemAttributeTerm');
Route::post('save-combined-order-setting','SettingController@saveCombinedOrderSettings');
Route::post('reformate-add-product-image','ProductVariationController@reformateAddProductImage');
Route::post('edit-order-address','OrderController@editOrderAddress');
Route::post('update-order-address','OrderController@updateOrderAddress');
Route::get('item-profiles','ProductDraftController2@itemProfiles');
Route::post('save-item-attribute-profile','ProductDraftController2@saveItemAttributeProfile');
Route::get('get-item-profile/{profileId}/{attributeId}','ProductDraftController2@getItemProfile');
Route::get('modify-item-profile/{profileId}/{attributeId}','ProductDraftController2@modifyItemProfile');
Route::post('delete-item-profile','ProductDraftController2@deleteItemProfile');
Route::post('master-catalogue-by-sku-ajax','ProductDraftController@masterCatalogueBySkuAjax');
Route::post('search-item-profile',function (Request $request){  //Shelf column search
    $url = '';
    foreach ($request->all() as $key => $value){
        if($key != '_token' && $key != 'route_name' && $request[$key] != null){
            $url .= $key.'='.$value.'&';
        }
    }
    $formated_url = 'is_search=true&'.rtrim($url,'&');
    return redirect(url($request->route_name.'?'.$formated_url));
});
Route::post('check-quantity-for-add-product-in-order','OrderController@checkQuantityForAddProductInOrder');
Route::get('check-catalogue-exist-in-channel/{channel}/{catalogueId}','ProductDraftController@checkCatalogueExistInChannel');
Route::group(['prefix' => 'shipping'],function(){
    Route::group(['prefix' => 'dpd'],function(){
        Route::post('fetch-dpd-available-info','ShippingController@fetchDPDAvailableInfo');
        Route::post('create-dpd-order','ShippingController@createDpdOrder');
    });
});
// Auth started
Auth::routes();

Route::get('dashboard','DashboardController@index')->middleware('admin:manager');

//  global reports route
Route::get('global_reports','reportController@globalReports');
Route::get('global_reports/unsold_catalogue_sku_report','reportController@unsoldCatalogueSku');
Route::post('global_reports/download-sku-sold-report-csv','reportController@unsoldCatalogueSkuCsvDownload');
Route::get('global_reports/catalogue-not-sell','reportController@catalogueNotSell');
Route::get('global_reports/unsold_catalogue_report','reportController@unsoldCatalogueReport');
Route::post('global_reports/download-catalouge-report-csv','reportController@unsoldCatalogueCsvDownload');
//Route::get('global_reports/view_report','reportController@viewReportTable');
//test route
Route::get('campaign-test','EbayMasterProductController@checkCampaign');
