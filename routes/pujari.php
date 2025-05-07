<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PujariController;
use App\Http\Controllers\FrontendController;


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



Route::post('send_otp',[PujariController::class, 'send_otp'])->name('pujari.send_otp');
Route::post('check_otp',[PujariController::class, 'check_otp'])->name('pujari.check_otp');
Route::get('/register', [FrontendController::class,'pujari_register'])->name('pujari.register');
Route::post('/attempt-register', [PujariController::class, 'attemptRegister'])->name('pujari_data.register');
Route::post('send_pujari_otp',[PujariController::class, 'send_pujari_otp'])->name('pujari.send_pujari_otp');

Route::post('pujari-login', [PujariController::class, 'attemptLogin'])->name('pujari.login');
Route::get('/pujari-logout', [PujariController::class,'attemptLogout'])->name('pujari.logout');
Route::post('get-pincode', [AdminController::class, 'getPincode'])->name('pujari.get-pincode');
Route::post('pujari_profile_update', [PujariController::class, 'profile_update'])->name('pujari.profile_update');
Route::post('pujari/bank_update', [PujariController::class, 'bank_update'])->name('pujari.bank_update');
Route::post('pujari/education_update', [PujariController::class, 'education_update'])->name('pujari.education_update');
Route::group(['middleware' => ['pujari']], function() {
    Route::view('pujari-profile', 'pujari_dashboard.pujari_profile')->name('pujari.profile');

     Route::group(['middleware' => ['is_pujari_verified']], function() {
        Route::get('/dashboard', function () {  return view('pujari_dashboard.dashboard'); })->name('pujari.dashboard');

        Route::get('/assign_puja', [PujariController::class,'assign_puja'])->name('assign_puja');
        Route::get('/assign_puja_show/{id}', [PujariController::class,'assign_puja_show'])->name('pujari.assign_puja_show');

        Route::get('/wallet', [PujariController::class,'wallet'])->name('wallet');
        Route::post('payment-status-update', [PujariController::class, 'payment_status_update'])->name('payment_status_update');
    });
});


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
