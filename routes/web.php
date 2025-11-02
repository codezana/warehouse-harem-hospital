<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\CustomAccessControl;


Auth::routes();

//Error page
Route::get('error-403', function () {
    return view('error.error-403');
})->name('error-403');

// Page comming for all page that Not Complete 
Route::get('/comming-soon', function () {
    return view('layouts.comming');
})->name('comming');


// System Wharehouse Harem Hospital

//Dashboard page
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home.page')->middleware('auth');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');
Route::get('/Sales-dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard')->middleware('exclude_check_permission', 'auth');


// Product Page  
Route::get('/assign-product', [App\Http\Controllers\Product\InsertControlller::class, 'productpage'])->name('productpage')->middleware('check_any_permission:Select all Product,Create Product', 'auth');
Route::post('/store-product', [App\Http\Controllers\Product\InsertControlller::class, 'store'])->name('product.store')->middleware('check_any_permission:Select all Product,Create Product', 'auth');
Route::get('/product-list', [App\Http\Controllers\Product\ListControlller::class, 'list'])->name('product.product.list')->middleware('check_any_permission:View Product,Edit Product,Select all Product,Delete Product,Create Product', 'auth');

//Unit Product page 
Route::get('/unit-list', [App\Http\Controllers\Product\ListControlller::class, 'typelist'])->name('typelist.page')->middleware('check_any_permission:View Product,Edit Product,Select all Product,Delete Product,Create Product', 'auth');

//Size Product page 
Route::get('/size-list', [App\Http\Controllers\Product\ListControlller::class, 'sizelist'])->name('sizelist.page')->middleware('check_any_permission:View Product,Edit Product,Select all Product,Delete Product,Create Product', 'auth');


// Print Product and Barcode   
Route::get('/Product-barcode/{productId}', [App\Http\Controllers\Product\PrintControlller::class, 'printProduct'])->name('print.product')->middleware('check_any_permission:Select all Product,Create Product', 'auth');

// Add Category Page  
Route::get('/assign-category', [App\Http\Controllers\Product\InsertControlller::class, 'Viewpage'])->name('categorypage')->middleware('check_any_permission:Select all Product,Create Product', 'auth');
Route::post('/store-category', [App\Http\Controllers\Product\InsertControlller::class, 'storePage'])->name('category.store')->middleware('check_any_permission:Select all Product,Create Product', 'auth');
Route::get('/category-list',  [App\Http\Controllers\Product\ListControlller::class, 'categorylist'])->name('product.categorylist')->middleware('check_any_permission:View Product,Edit Product,Select all Product,Delete Product,Create Product', 'auth');


// Add Sub Category Page  
Route::get('/assign-subCategory',  [App\Http\Controllers\Product\InsertControlller::class, 'Viewcreate'])->name('subcategorypage')->middleware('check_any_permission:Select all Product,Create Product', 'auth');
Route::post('/store-subCategory', [App\Http\Controllers\Product\InsertControlller::class, 'storeView'])->name('subcategory.store')->middleware('check_any_permission:Select all Product,Create Product', 'auth');
Route::get('/subCategory-list',  [App\Http\Controllers\Product\ListControlller::class, 'subcategorylist'])->name('product.subcategorylist')->middleware('check_any_permission:View Product,Edit Product,Select all Product,Delete Product,Create Product', 'auth');


// Add Brand Page  
Route::get('/assign-brand',  [App\Http\Controllers\Product\InsertControlller::class, 'view'])->name('addbrandpage')->middleware('check_any_permission:Select all Product,Create Product', 'auth');
Route::post('/store-brand', [App\Http\Controllers\Product\InsertControlller::class, 'create'])->name('addbrand.store')->middleware('check_any_permission:Select all Product,Create Product', 'auth');
Route::get('/brand-list', [App\Http\Controllers\Product\ListControlller::class, 'Viewlist'])->name('product.brand.list')->middleware('check_any_permission:View Product,Edit Product,Select all Product,Delete Product,Create Product', 'auth');


//sale page
Route::get('/assign-sales',  [App\Http\Controllers\Sales\InsertControlller::class, 'view'])->name('addsales.page')->middleware('check_any_permission:Select all Sales,Create Sales', 'auth');
Route::post('/store-sales',  [App\Http\Controllers\Sales\InsertControlller::class, 'storeTableData'])->name('store_sales')->middleware('check_any_permission:Select all Sales,Create Sales', 'auth');
Route::get('/sales-list',  [App\Http\Controllers\Sales\ListControlller::class, 'home'])->name('saleslist.page')->middleware('check_any_permission:View Sales,Edit Sales,Select all Sales,Delete Sales,Create Sales', 'auth');
Route::get('/print-invoice',  [App\Http\Controllers\Invoice\UpdateControlller::class, 'print'])->name('print.invoice')->middleware('check_any_permission:Edit Invoices,Select all Invoices', 'auth');
Route::get('/sale-invoice',  [App\Http\Controllers\Invoice\UpdateControlller::class, 'saleInvoice'])->name('sale.invoice')->middleware('check_any_permission:Edit Invoices,Select all Invoices', 'auth');

//Request page 
Route::post('/store-order', [App\Http\Controllers\Request\InsertControlller::class, 'submitOrders'])->name('submitOrder')->middleware('exclude_check_permission', 'auth');
Route::get('/request-order',  [App\Http\Controllers\Request\ViewControlller::class, 'view'])->name('request.page')->middleware('exclude_check_permission', 'auth');
//Store Requests when access
Route::post('/store-request',  [App\Http\Controllers\Request\InsertControlller::class, 'storeRequests'])->name('store_requests')->middleware('exclude_check_permission', 'auth');

// Pos Page 
Route::post('store-pos', [App\Http\Controllers\POS\InsertControlller::class, 'storeOrderpos'])->name('store.pos')->middleware('check_any_permission:Select all Sales,Create Sales', 'auth');
Route::get('/pos',  [App\Http\Controllers\POS\ShowControlller::class, 'view'])->name('pos.page')->middleware('check_any_permission:View Sales,Edit Sales,Select all Sales,Delete Sales,Create Sales', 'auth');
Route::get('/fetch-transaction',  [App\Http\Controllers\POS\ShowControlller::class, 'fetchTransaction'])->name('fetch.transaction')->middleware('check_any_permission:View Sales,Edit Sales,Select all Sales,Delete Sales,Create Sales', 'auth');



//Notification Sales Requests in List
Route::get('/activities',  [App\Http\Controllers\Request\ViewControlller::class, 'activities'])->name('activities.page')->middleware('check_any_permission:View Notification,Edit Notification,Select all Notification,Delete Notification,Create Notification', 'auth');


// Sales Return Page
Route::get('/assign-salesReturn',  [App\Http\Controllers\Sales\InsertControlller::class, 'home'])->name('createsalesreturns.page')->middleware('check_any_permission:Select all Sales,Create Sales', 'auth');
Route::post('store-salesReturn',  [App\Http\Controllers\Sales\InsertControlller::class, 'storeTableReturn'])->name('store_sales_return')->middleware('check_any_permission:Select all Sales,Create Sales', 'auth');
Route::get('/salesReturn-list',  [App\Http\Controllers\Sales\ListControlller::class, 'ViewReturn'])->name('salesreturnlist.page')->middleware('check_any_permission:View Sales,Edit Sales,Select all Sales,Delete Sales,Create Sales', 'auth');


// Customer Page
Route::get('/assign-customer',  [App\Http\Controllers\Customer\InsertControlller::class, 'home'])->name('addcustomer.page')->middleware('check_any_permission:Select all Customer,Create Customer', 'auth');
Route::post('/store-customer', [App\Http\Controllers\Customer\InsertControlller::class, 'store'])->name('addcustomer.store')->middleware('check_any_permission:Select all Customer,Create Customer', 'auth');
Route::get('/customer-list', [App\Http\Controllers\Customer\ListControlller::class, 'customerlist'])->name('customerlist.page')->middleware('check_any_permission:View Customer,Edit Customer,Select all Customer,Delete Customer,Create Customer', 'auth');


//Purchase Page
Route::get('/assign-purchase',  [App\Http\Controllers\Purchase\InsertControlller::class, 'home'])->name('addpurchasepage')->middleware('check_any_permission:Select all Purchase,Create Purchase', 'auth');
Route::post('/store-purchase',  [App\Http\Controllers\Purchase\InsertControlller::class, 'storeTableData'])->name('purchase.store')->middleware('check_any_permission:Select all Purchase,Create Purchase', 'auth');
Route::get('/purchase-list',  [App\Http\Controllers\Purchase\ListControlller::class, 'home'])->name('purchaselistpage')->middleware('check_any_permission:View Purchase,Edit Purchase,Select all Purchase,Delete Purchase,Create Purchase', 'auth');



// Expired List
Route::get('/expired-list',  [App\Http\Controllers\Purchase\ListControlller::class, 'expiredlist'])->name('expiredlist.page')->middleware('check_any_permission:View Notification,Edit Notification,Select all Notification,Delete Notification,Create Notification', 'auth');


//Users Page
Route::get('/assign-user', [App\Http\Controllers\Users\InsertControlller::class, 'newuser'])->name('newuser')->middleware('check_any_permission:Select all User Management,Create User Management', 'auth');
Route::post('/check-email-existence-user', [App\Http\Controllers\Users\InsertControlller::class, 'checkEmailExistenceuser'])->name('checkEmailExistenceuser');
Route::post('/store-user', [App\Http\Controllers\Users\InsertControlller::class, 'storeUser'])->name('store.user')->middleware('check_any_permission:Select all User Management,Create User Management', 'auth');
Route::get('/user-list', [App\Http\Controllers\Users\ListControlller::class, 'userlists'])->name('userlists')->middleware('check_any_permission:View User Management,Edit User Management,Select all User Management,Delete User Management,Create User Management', 'auth');


// Permission And Role System
Route::get('/assign-permissions',  [App\Http\Controllers\Setting\InsertControlller::class, 'home'])->name('createpermission.page')->middleware('check_any_permission:Select all Premission,Create Premission', 'auth');
Route::post('/store-permissions', [App\Http\Controllers\Setting\InsertControlller::class, 'storeRole'])->name('permissions.store')->middleware('check_any_permission:Select all Premission,Create Premission', 'auth');
Route::get('/role-permissions',  [App\Http\Controllers\Setting\ListControlller::class, 'home'])->name('grouppermissions.page')->middleware('check_any_permission:View Premission,Edit Premission,Select all Premission,Delete Premission,Create Premission', 'auth');
Route::post('/check-role-existence', [App\Http\Controllers\Setting\InsertControlller::class, 'checkRole'])->name('checkRole');


//Disable Users
Route::get('/toggle-status/{id}', [App\Http\Controllers\Users\ListControlller::class, 'toggleStatus'])->name('toggleStatus')->middleware('check_any_permission:View User Management,Edit User Management,Select all User Management,Delete User Management,Create User Management', 'auth');

//Note Page
Route::get('/stickyNote',  [App\Http\Controllers\Note\InsertControlller::class, 'home'])->name('stickynote.page')->middleware('auth');
Route::post('/store-note', [App\Http\Controllers\Note\InsertControlller::class, 'addNote'])->name('addnote.store')->middleware('auth');
Route::get('/notes', [App\Http\Controllers\Note\ListControlller::class, 'getUserNotes'])->name('getusernotes')->middleware('auth');


//Application Page
Route::get('/email',  [App\Http\Controllers\Application\EmailController::class, 'home'])->name('email.page')->middleware('check_any_permission:View Application,Edit Application,Select all Application,Delete Application,Create Application', 'auth');
Route::get('/chat',  [App\Http\Controllers\Application\ChatController::class, 'home'])->name('chat.page')->middleware('check_any_permission:View Application,Edit Application,Select all Application,Delete Application,Create Application', 'auth');

//Setting Page
Route::get('/profile',  [App\Http\Controllers\Setting\ProfileController::class, 'home'])->name('profile.page')->middleware('auth');



//Report Section 
Route::get('/customer-report', [App\Http\Controllers\Report\ListControlller::class, 'showcustomer'])->name('customer.report')->middleware('check_any_permission:View Reports,Edit Reports,Select all Reports,Delete Reports,Create Reports', 'auth');
Route::get('/invoice-report', [App\Http\Controllers\Report\ListControlller::class, 'showinvoice'])->name('invoice.report')->middleware('check_any_permission:View Reports,Edit Reports,Select all Reports,Delete Reports,Create Reports', 'auth');
Route::get('/inventory-report', [App\Http\Controllers\Report\ListControlller::class, 'showinventory'])->name('inventory.report')->middleware('check_any_permission:View Reports,Edit Reports,Select all Reports,Delete Reports,Create Reports', 'auth');
Route::get('/sales-report', [App\Http\Controllers\Report\ListControlller::class, 'showsales'])->name('sales.report')->middleware('check_any_permission:View Reports,Edit Reports,Select all Reports,Delete Reports,Create Reports', 'auth');
Route::get('/purchase-report', [App\Http\Controllers\Report\ListControlller::class, 'showpurchase'])->name('purchase.report')->middleware('check_any_permission:View Reports,Edit Reports,Select all Reports,Delete Reports,Create Reports', 'auth');
Route::get('/Supplier-report', [App\Http\Controllers\Report\ListControlller::class, 'showsupplier'])->name('supplier.report')->middleware('check_any_permission:View Reports,Edit Reports,Select all Reports,Delete Reports,Create Reports', 'auth');
Route::post('/advanced-report-purchase', [App\Http\Controllers\Report\AdvancedControlller::class, 'purchaseAdvanced'])->name('purchase.advanced')->middleware('check_any_permission:View Reports,Edit Reports,Select all Reports,Delete Reports,Create Reports', 'auth');
Route::get('/advanced-invoice-purchase', [App\Http\Controllers\Report\AdvancedControlller::class, 'purchaseview'])->name('purchase.invoice')->middleware('check_any_permission:View Reports,Edit Reports,Select all Reports,Delete Reports,Create Reports', 'auth');
Route::post('/advanced-report-sales', [App\Http\Controllers\Report\AdvancedControlller::class, 'salesAdvanced'])->name('sales.advanced')->middleware('check_any_permission:View Reports,Edit Reports,Select all Reports,Delete Reports,Create Reports', 'auth');
Route::get('/advanced-invoice-sales', [App\Http\Controllers\Report\AdvancedControlller::class, 'salesview'])->name('sales.invoice')->middleware('check_any_permission:View Reports,Edit Reports,Select all Reports,Delete Reports,Create Reports', 'auth');
Route::post('/advanced-report-sold', [App\Http\Controllers\Report\AdvancedControlller::class, 'soldAdvanced'])->name('sold.advanced')->middleware('check_any_permission:View Reports,Edit Reports,Select all Reports,Delete Reports,Create Reports', 'auth');
Route::get('/advanced-invoice-sold', [App\Http\Controllers\Report\AdvancedControlller::class, 'soldview'])->name('sold.invoice')->middleware('check_any_permission:View Reports,Edit Reports,Select all Reports,Delete Reports,Create Reports', 'auth');
Route::post('/report-purchase-qty', [App\Http\Controllers\Report\AdvancedControlller::class, 'qtyAdvanced'])->name('qty.advanced')->middleware('check_any_permission:View Reports,Edit Reports,Select all Reports,Delete Reports,Create Reports', 'auth');
Route::get('/invoice-purchase-qty', [App\Http\Controllers\Report\AdvancedControlller::class, 'qtyview'])->name('qty.invoice')->middleware('check_any_permission:View Reports,Edit Reports,Select all Reports,Delete Reports,Create Reports', 'auth');


//Convert DisActive to Active Request
Route::get('/request-report', [App\Http\Controllers\Report\ListControlller::class, 'showrequest'])->name('request.report')->middleware('check_any_permission:View Reports,Edit Reports,Select all Reports,Delete Reports,Create Reports', 'auth');
Route::get('/toggle-status-order', [App\Http\Controllers\Report\ListControlller::class, 'toggleStatusorder'])->name('toggleStatusorder')->middleware('check_any_permission:Edit Reports,Select all Reports', 'auth');


// Supplier Page
Route::get('/assign-supplier',  [App\Http\Controllers\Supplier\InsertControlller::class, 'home'])->name('addsupplier.page')->middleware('check_any_permission:Select all Supplier,Create Supplier', 'auth');
Route::post('/store-supplier', [App\Http\Controllers\Supplier\InsertControlller::class, 'store'])->name('addsupplier.store')->middleware('check_any_permission:Select all Supplier,Create Supplier', 'auth');
Route::get('/supplier-list', [App\Http\Controllers\Supplier\ListControlller::class, 'supplierlist'])->name('supplierlist.page')->middleware('check_any_permission:View Supplier,Edit Supplier,Select all Supplier,Delete Supplier,Create Supplier', 'auth');


//Refresh icon for sales dashboard 
Route::get('/total-quantity-sold', [App\Http\Controllers\HomeController::class, 'getTotalQuantitySold'])->name('getTotalQuantitySold')->middleware('auth');
Route::get('/total-sales-due', [App\Http\Controllers\HomeController::class, 'getTotalSalesDue'])->name('getTotalSalesDue')->middleware('auth');

//Refresh in Side bar 
Route::get('/getExpireCountAndList', [App\Http\Controllers\HomeController::class, 'getExpireCountAndList'])->name('getExpireCountAndList')->middleware('auth');
Route::get('/getOrderCountAndList', [App\Http\Controllers\HomeController::class, 'getOrderCountAndList'])->name('getOrderCountAndList')->middleware('auth');
Route::get('/Alert-quanity', [App\Http\Controllers\HomeController::class, 'alert'])->name('alret.quantity')->middleware('auth');


// Model In pages

Route::post('/category-model', [App\Http\Controllers\Models\InsertControlller::class, 'storeCategory'])->name('category.model')->middleware('auth');
Route::get('categories', [App\Http\Controllers\Models\InsertControlller::class, 'fetchCategories'])->name('categories.fetch');
//Sub Category 
Route::post('/subCategory-model', [App\Http\Controllers\Models\InsertControlller::class, 'storeSubCategory'])->name('Subcategory.model')->middleware('auth');
Route::get('subCategories', [App\Http\Controllers\Models\InsertControlller::class, 'fetchsubCategory'])->name('Subcategories.fetch');

//Brand 
Route::post('/brand-model', [App\Http\Controllers\Models\InsertControlller::class, 'storebrand'])->name('brand.model')->middleware('auth');
Route::get('brandModel', [App\Http\Controllers\Models\InsertControlller::class, 'fetchBrand'])->name('BrandModel.fetch');

//Type 
Route::post('/type-model', [App\Http\Controllers\Models\InsertControlller::class, 'storetype'])->name('Type.model')->middleware('auth');
Route::get('typeModel', [App\Http\Controllers\Models\InsertControlller::class, 'fetchtype'])->name('TypeModel.fetch');

//Customer 
Route::post('/customer-model', [App\Http\Controllers\Models\InsertControlller::class, 'storeCustomer'])->name('Customer.model')->middleware('auth');
Route::get('customerModel', [App\Http\Controllers\Models\InsertControlller::class, 'fetchCustomer'])->name('CustomerModel.fetch');
Route::post('/check-email-existence-customer', [App\Http\Controllers\Models\InsertControlller::class, 'checkEmailExistenceCustomer'])->name('checkEmailExistenceCustomer');


//Supplier 
Route::post('/supplier-model', [App\Http\Controllers\Models\InsertControlller::class, 'storeSupplier'])->name('Supplier.model')->middleware('auth');
Route::get('supplierModel', [App\Http\Controllers\Models\InsertControlller::class, 'fetchSupplier'])->name('SupplierModel.fetch');
Route::post('/check-email-existence', [App\Http\Controllers\Models\InsertControlller::class, 'checkEmailExistence'])->name('checkEmailExistence');


//Product 
Route::post('/product-model', [App\Http\Controllers\Models\InsertControlller::class, 'storeProduct'])->name('Product.model')->middleware('auth');
Route::get('productModel', [App\Http\Controllers\Models\InsertControlller::class, 'fetchProduct'])->name('ProductModel.fetch');
Route::get('productModelSale', [App\Http\Controllers\Models\InsertControlller::class, 'fetchProductsale'])->name('ProductModelsale.fetch');


//Size 
Route::post('/size-model', [App\Http\Controllers\Models\InsertControlller::class, 'storesize'])->name('size.model')->middleware('auth');
Route::get('SizeModel', [App\Http\Controllers\Models\InsertControlller::class, 'fetchsize'])->name('sizeModel.fetch');

//Invoice page 
Route::get('/invoice-list', [App\Http\Controllers\Invoice\UpdateControlller::class, 'view'])->name('invoice.page')->middleware('check_any_permission:View Invoices,Edit Invoices,Select all Invoices,Delete Invoices,Create Invoices', 'auth');



//PDF Excel Print Of All Pages
Route::get('/generate-pdf', [App\Http\Controllers\Users\PDFController::class, 'generatePDF'])->name('generatePDF')->middleware('auth');
Route::get('/generate-excel', [App\Http\Controllers\Users\ExcelController::class, 'generateExcel'])->name('generateExcel')->middleware('auth');
Route::get('/generate-print', [App\Http\Controllers\Users\PrintController::class, 'generatePrint'])->name('generatePrint')->middleware('auth');



// Restric All Edit and View Content Page 

Route::group(['middleware' => 'restrict.url'], function () {

    //View  Content

    Route::get('/product-content', [App\Http\Controllers\Product\ListControlller::class, 'product_details'])->name('product.product.details')->middleware('auth');
    Route::get('/sales-content', [App\Http\Controllers\Sales\ListControlller::class, 'sale_details'])->name('sale.details')->middleware('auth');
    Route::get('/salesReturn-content', [App\Http\Controllers\Sales\ListControlller::class, 'sale_return_details'])->name('sale.return.details')->middleware('auth');
    Route::get('/purchase-content', [App\Http\Controllers\Purchase\ListControlller::class, 'details'])->name('purchase.details')->middleware('auth');


    // Edit Product and Delete
    Route::get('/edit-product', [App\Http\Controllers\Product\UpdateController::class, 'editproduct'])->name('product.edit')->middleware('auth');
    Route::post('/update-product', [App\Http\Controllers\Product\UpdateController::class, 'updateproduct'])->name('product.update')->middleware('auth');
    Route::delete('/delete-product', [App\Http\Controllers\Product\DeleteController::class, 'delete'])->name('product.delete')->middleware('auth');

    // Edit Category and Delete
    Route::get('/edit-category', [App\Http\Controllers\Product\UpdateController::class, 'editcategory'])->name('product.category.edit')->middleware('auth');
    Route::post('/update-category', [App\Http\Controllers\Product\UpdateController::class, 'updatecategory'])->name('product.category.update')->middleware('auth');
    Route::delete('/delete-category', [App\Http\Controllers\Product\DeleteController::class, 'deletecategory'])->name('category.delete')->middleware('auth');

    // Edit Sub Category and Delete
    Route::get('/edit-subCategory', [App\Http\Controllers\Product\UpdateController::class, 'editsubcategory'])->name('product.subcategory.edit')->middleware('auth');
    Route::post('/update-subCategory', [App\Http\Controllers\Product\UpdateController::class, 'updatesubcategory'])->name('product.subcategory.update')->middleware('auth');
    Route::delete('/delete-subcategory', [App\Http\Controllers\Product\DeleteController::class, 'deletesubcategory'])->name('subcategory.delete');

    // Edit Brand and Delete
    Route::get('/edit-brand', [App\Http\Controllers\Product\UpdateController::class, 'editBrand'])->name('product.brand.edit')->middleware('auth');
    Route::post('/update-brand', [App\Http\Controllers\Product\UpdateController::class, 'updateBrand'])->name('product.brand.update')->middleware('auth');
    Route::delete('/delete-brand', [App\Http\Controllers\Product\DeleteController::class, 'deleteBrand'])->name('product.brand.delete')->middleware('auth');

    // Edit Customer and Delete
    Route::get('/edit-customer', [App\Http\Controllers\Customer\UpdateController::class, 'editcustomer'])->name('editcustomer.page')->middleware('auth');
    Route::post('/update-customer', [App\Http\Controllers\Customer\UpdateController::class, 'updatecustomer'])->name('updatecustomer')->middleware('auth');
    Route::delete('/delete-customer', [App\Http\Controllers\Customer\DeleteControlller::class, 'deletecustomer'])->name('customer.delete')->middleware('auth');


    //Supplier Edit And Delete
    Route::get('/edit-supplier', [App\Http\Controllers\Supplier\UpdateControlller::class, 'editsupplier'])->name('editsupplier.page')->middleware('auth');
    Route::post('/update-supplier', [App\Http\Controllers\Supplier\UpdateControlller::class, 'updatesupplier'])->name('updatesupplier')->middleware('auth');
    Route::delete('/delete-supplier', [App\Http\Controllers\Supplier\DeleteControlller::class, 'deletesupplier'])->name('supplier.delete')->middleware('auth');

    // Edit Users and Delete
    Route::get('/edit-users', [App\Http\Controllers\Users\UpdateControlller::class, 'editusers'])->name('users.edit')->middleware('auth');
    Route::post('/update-user', [App\Http\Controllers\Users\UpdateControlller::class, 'updateusers'])->name('UpdateUser')->middleware('auth');
    Route::delete('/distroy-user', [App\Http\Controllers\Users\DeleteControlller::class, 'distroy'])->name('distroy.user')->middleware('auth');


    // Edit Primission and Delete 
    Route::get('/edit-premission', [App\Http\Controllers\Setting\UpdateControlller::class, 'editPremission'])->name('editPremission.page')->middleware('auth');
    Route::post('/update-premission', [App\Http\Controllers\Setting\UpdateControlller::class, 'updatePremission'])->name('updatePremission.page')->middleware('auth');
    Route::delete('/delete-premission', [App\Http\Controllers\Setting\DeleteControlller::class, 'deletePremission'])->name('Premission.delete')->middleware('auth');


    // Edit Type and Delete !!
    Route::get('/edit-unit', [App\Http\Controllers\Product\UpdateController::class, 'editUnit'])->name('unit.edit')->middleware('auth');
    Route::post('/update-unit', [App\Http\Controllers\Product\UpdateController::class, 'updateUnit'])->name('unit.update')->middleware('auth');
    Route::delete('/delete-unit', [App\Http\Controllers\Product\DeleteController::class, 'deleteUnit'])->name('unit.delete')->middleware('auth');

    // Edit Type and Delete !!
    Route::get('/edit-size', [App\Http\Controllers\Product\UpdateController::class, 'editsize'])->name('size.edit')->middleware('auth');
    Route::post('/update-size', [App\Http\Controllers\Product\UpdateController::class, 'updatesize'])->name('size.update')->middleware('auth');
    Route::delete('/delete-size', [App\Http\Controllers\Product\DeleteController::class, 'deletesize'])->name('size.delete')->middleware('auth');

    //Edit Sale Delete 
    Route::get('/edit-sale', [App\Http\Controllers\Sales\UpdateControlller::class, 'editsale'])->name('sale.edit')->middleware('auth');
    Route::put('/update-sale', [App\Http\Controllers\Sales\UpdateControlller::class, 'update'])->name('update.sale.page')->middleware('auth');
    Route::delete('/delete-sale', [App\Http\Controllers\Sales\DeleteControlller::class, 'deleteSet'])->name('delete.set')->middleware('auth');


    //Edit Sale return Delete 
    Route::get('/edit-SaleReturn', [App\Http\Controllers\Sales\UpdateControlller::class, 'editreturn'])->name('sale.edit.return')->middleware('auth');
    Route::put('/update-saleReturn', [App\Http\Controllers\Sales\UpdateControlller::class, 'updatereturn'])->name('update.sale.return.page')->middleware('auth');
    Route::delete('/delete-saleReturn', [App\Http\Controllers\Sales\DeleteControlller::class, 'destroy'])->name('destroy.sale.return')->middleware('auth');

    //Edit Purchase 
    Route::get('/edit-purchase', [App\Http\Controllers\Purchase\UpdateControlller::class, 'edit'])->name('edit.purchase')->middleware('auth');
    Route::put('/update-purchase', [App\Http\Controllers\Purchase\UpdateControlller::class, 'update'])->name('update.purchase')->middleware('auth');
    Route::delete('/delete-purchase', [App\Http\Controllers\Purchase\DeleteControlller::class, 'destroy'])->name('destroy.purchase')->middleware('auth');

    // Edit Invoice and Delete !!
    Route::get('/edit-invoice', [App\Http\Controllers\Product\UpdateController::class, 'editinvoice'])->name('invoice.edit')->middleware('auth');
    Route::post('/update-invoice', [App\Http\Controllers\Product\UpdateController::class, 'updateinvoice'])->name('invoice.update')->middleware('auth');
    Route::delete('/delete-invoice', [App\Http\Controllers\Product\DeleteController::class, 'deleteinvoice'])->name('invoice.delete')->middleware('auth');


    // Reset Password
    Route::put('/update-password', [App\Http\Controllers\Users\ResetControlller::class, 'reset'])->name('resetPassword')->middleware('auth');

    // Edit Profile and Delete
    Route::post('/profile/update/image', [App\Http\Controllers\Setting\ProfileController::class, 'profile'])->name('profile.update.image')->middleware('auth');
    Route::post('/profile/update/info', [App\Http\Controllers\Setting\ProfileController::class, 'infoProfile'])->name('profile.update.info')->middleware('auth');



    // Edit Note and Delete
    Route::post('/update-note', [App\Http\Controllers\Note\DeleteControlller::class, 'updateNote'])->name('updatenote')->middleware('auth');
    Route::delete('/delete-note', [App\Http\Controllers\Note\DeleteControlller::class, 'deleteNote'])->name('deletenote')->middleware('auth');

    //Show sales and Update records
    Route::get('/view-request', [App\Http\Controllers\Request\InsertControlller::class, 'view'])->name('show_sales')->middleware('auth');
    Route::post('/cancle-button-request', [App\Http\Controllers\Request\UpdateControlller::class, 'updateOrderRecord'])->name('update_order_records')->middleware('auth');;
});
