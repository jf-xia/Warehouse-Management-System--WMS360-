<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'AuthController@login');
Route::post('login-with-id', 'AuthController@loginWithId');
Route::get('client/{id}', 'AuthController@client')->middleware('auth:api');
Route::post('register', 'AuthController@register');
Route::get('assigned-self-list', 'AuthController@assignedShelfList');
Route::post('product-shelve', 'AuthController@productShelve');
Route::post('product-pick', 'AuthController@productPick');
Route::post('product-reshelve', 'AuthController@productReshelve');
Route::post('shelve-reshelved-product', 'AuthController@shelveReshelvedProduct');
Route::get('assigned-oder-list', 'AuthController@assignedOrderList');
Route::get('reshelve-product-list', 'AuthController@reshelveProductList');
Route::get('product-shelf-list', 'AuthController@productShelveList');
Route::post('shelfed-product-list-by-sku','AuthController@shelfedProductListBySKU');
Route::get('app-url', 'AuthController@appUrl');
Route::get('single-shelf-product','AuthController@singleShelfProduct');
Route::post('search-assign-shelf-list','AuthController@searchAssignShelfList');
Route::get('filter-assigned-oder-list', 'AuthController@filterAssignedOrderList');
Route::get('shelver-history','AuthController@shelverHistory');
Route::get('picker-history','AuthController@pickerHistory');
Route::get('single-shelf-ordered-product-list','AuthController@singleShelfOrderedProductList');
Route::get('group-postcode-ordered-product-list','AuthController@groupPostcodeOrderedProductList');
Route::get('group-sku-order-list','AuthController@groupSkuOrderList');
Route::prefix('invoice')->group(function (){
    Route::get('receive','AuthController@receiveInvoice');
    Route::get('exist-invoice','AuthController@existInvoice');
    Route::post('variation-info','AuthController@variationInfo');
    Route::post('product-receive','AuthController@invoiceProductReceive');
//    Route::post('save-invoice','AuthController@saveInvoice');
});
Route::get('category-list', 'WooController@category');
Route::get('attribute-list', 'WooController@attributeList');
Route::get('attribute-terms-list', 'WooController@attributeTermsList');
Route::get('product-draft-list', 'WooController@draftProduct');
Route::get('product-draft-category', 'WooController@draftProductCategory');
Route::get('product-draft-image', 'WooController@draftProductImage');
Route::get('product-variation', 'WooController@ProductVariation');
Route::get('test1', 'WooController@test1');
Route::get('product-variation-quantity', 'WooController@ProductVariationQuantity');
Route::get('test', 'WooController@test');
Route::get('shelf-info/{shelfId}','AuthController@shelfInfo');
Route::post('shelf-migration','AuthController@shelfMigration');
Route::post('get-order-product-by-sku','AuthController@getOrderProductBySKU');
Route::post('bulk-product-pick','AuthController@bulkProductPick');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::any('/auto-git-pull', 'TestController@test');
Route::any('/auto-git-pull-2', 'TestControllerTwo@test');
Route::any('/migrate', 'TestController@migrate');

Route::post('reshelved-product','ShelfController@reshelved_product');


Route::post('update-password', 'Auth\MasterAppApiController@updatePasswordApi');
Route::post('update-packages', 'Auth\MasterAppApiController@updatePackagesApi');
Route::post('get-packages-info', 'Auth\MasterAppApiController@infoPackagesApi');
Route::post('create-support-user', 'Auth\MasterAppApiController@CreateSupportUser');
Route::post('support-user-delete', 'Auth\MasterAppApiController@deleteSupportUser');
Route::post('manual-order', 'AuthController@manualOrderApi');
Route::post('hold-order', 'AuthController@holdOrder');
Route::post('store-shelve-error','AuthController@storeShelveError');


// Route::post('login', 'Auth\MasterAppApiController@login');
// Route::post('logout', 'MasterAppApiController@logout');
// Route::post('refresh', 'MasterAppApiController@refresh');
// Route::post('me', 'MasterAppApiController@me');
Route::post('register', 'Auth\MasterAppApiController@register');

Route::post('logout', 'Auth\MasterAppApiController@logout');
