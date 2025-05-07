<?php

// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\PosController;
// use App\Http\Controllers\HomeController;
// use App\Http\Controllers\OrderController;
// use App\Http\Controllers\VendorController;
// use App\Http\Controllers\ServiceController;
// use App\Http\Controllers\SubCategoryController;
// use App\Http\Controllers\VendorProductController;
// use App\Http\Controllers\VendorServiceController;
// use App\Http\Controllers\ServiceSubCategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/login', [VendorController::class,'vendorLogin'])->name('vendor_login');
// Route::get('/register', [VendorController::class,'vendorRegister'])->name('vendor_register');
// Route::get('/forgot-password', [VendorController::class,'vendorForgotPassword'])->name('vendor_forgot_password');
// Route::get('/reset-password', [VendorController::class,'vendorResetPassword'])->name('vendor_reset_password');
// Route::get('/logout', [VendorController::class,'vendorlogout'])->name('vendor_logout');
// Route::get('/checkemail', [VendorController::class,'checkemail'])->name('checkemail');
// Route::post('attempt-login', [VendorController::class, 'attemptLogin'])->name('vendor.login');
// Route::post('attempt-register', [VendorController::class, 'attemptRegister'])->name('vendor.register');
// Route::get('/checkreferral', [HomeController::class,'checkreferral'])->name('checkreferral');

// Route::get('get_category_by_vendor', [VendorController::class,'get_category_by_vendor'])->name('get_category_by_vendor');
// Route::get('get_sub_category_by_category', [SubCategoryController::class,'get_sub_category_by_category'])->name('get_sub_category_by_category');

// Route::get('get_service_category_by_vendor', [VendorController::class,'get_service_category_by_vendor'])->name('get_service_category_by_vendor');
// Route::get('get_service_sub_category_by_category', [ServiceSubCategoryController::class,'get_service_sub_category_by_category'])->name('get_service_sub_category_by_category');

// Route::group(['middleware' => ['vendor','unbanned']], function() {
//     Route::get('/dashboard', function () {  return view('vendor_dashboard.dashboard'); })->name('vendor.dashboard');


//     Route::resource('product', VendorProductController::class);
//     Route::post('product/update-featured', [VendorProductController::class, 'updateFeatured'])->name('product.update_featured');
//     Route::post('product/update-status', [VendorProductController::class, 'updateStatus'])->name('product.update_status');



//     Route::post('projects/media', [VendorProductController::class, 'storeMedia'])->name('projects.storeMedia');

//     Route::resource('service', VendorServiceController::class);
//     Route::post('service/update-featured', [VendorServiceController::class, 'updateFeatured'])->name('service.update_featured');
//     Route::post('service/update-status', [VendorServiceController::class, 'updateStatus'])->name('service.update_status');


//     Route::post('projects/media_service', [ServiceController::class, 'storeMedia'])->name('projects.storeMedia_service');

//     Route::get('topup_category', [VendorController::class,'topup_category'])->name('topup_category');


//     Route::view('vendor-profile', 'vendor_dashboard.vendor_profile')->name('vendor.profile');

//     Route::post('vendor_registration_fess', [VendorController::class, 'vendor_registration_fess'])->name('vendor.pay_registration_fee');
//     Route::post('vendor_categories_prdouct_fess', [VendorController::class, 'vendor_categories_product_fess'])->name('vendor.pay_vendor_categories_product_fess');
//     Route::post('vendor_categories_service_fess', [VendorController::class, 'vendor_categories_service_fess'])->name('vendor.pay_vendor_categories_service_fess');

//     Route::post('vendor_registration_fess_phonepe', [VendorController::class, 'vendor_registration_fess_phonepe'])->name('vendor.pay_registration_fee_phonepe');
//     Route::post('vendor_categories_product_fess_phonepe', [VendorController::class, 'vendor_categories_product_fess_phonepe'])->name('vendor.vendor_categories_product_fess_phonepe');
//     Route::post('vendor_categories_service_fess_phonepe', [VendorController::class, 'vendor_categories_service_fess_phonepe'])->name('vendor.vendor_categories_service_fess_phonepe');

//     Route::get('vendor_payment_histroy', [VendorController::class,'vendor_payment_histroy'])->name('vendor_payment_histroy');

//     Route::post('vendor_profile_update', [VendorController::class, 'profile_update'])->name('vendor.profile_update');

//     Route::get('order', [OrderController::class, 'vendor_order'])->name('vendor.orders');
//     Route::get('order/show/{id}', [OrderController::class, 'vendor_order_details'])->name('vendor.order_show');
//     Route::post('order/update_delivery_status', [OrderController::class, 'update_delivery_status'])->name('order.update_delivery_status');

//     Route::get('service_order', [OrderController::class, 'vendor_service_order'])->name('vendor.service_orders');
//     Route::get('service_order/show/{id}', [OrderController::class, 'vendor_service_order_details'])->name('vendor.service_order_show');
//     Route::post('service_order/update_delivery_status', [OrderController::class, 'update_service_order_delivery_status'])->name('service_order.update_delivery_status');


//     Route::resource('pos', PosController::class);


// });
