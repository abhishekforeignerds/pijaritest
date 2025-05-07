<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PosController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\EPujaController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\PujariController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\KundaliController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AppSetupController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OurPujariController;
use App\Http\Controllers\TemplePujaController;
use App\Http\Controllers\DeliveryBoyController;
use App\Http\Controllers\PujaBenifitController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\TempleDetailController;
use App\Http\Controllers\ServiceCategoryController;
use App\Http\Controllers\BusinessCategoryController;
use App\Http\Controllers\ServiceSubCategoryController;
use App\Http\Controllers\PoojaController;

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

Route::get('download_invoice/{id}',[OrderController::class,'download_invoice'])->name('order.download_invoice');
// Route::view('view-invoice', 'backend.order.download_invoice')->name('download_invoice');
// Route::view('invoice', 'backend.order.invoice')->name('invoice');

Route::get('/login', [AdminController::class,'adminLogin'])->name('admin_login');

Route::get('/file-import',[AdminController::class,'importView'])->name('import.view');
Route::post('/upload_user',[AdminController::class,'uploadUsers'])->name('import.user');

Route::get('/reward_check', [AdminController::class,'reward_check'])->name('reward_check');

Route::get('/bonanza_reward_check/{id}', [AdminController::class,'bon_reward'])->name('bonanza_reward_check');

Route::get('/bonanza_reward_check_all', [AdminController::class,'bonanza_reward_check_all'])->name('bonanza_reward_check_all');


Route::get('get_pincode', [AdminController::class,'get_pincode'])->name('admin.get_pincode');
Route::get('pincode_list', [AdminController::class,'pincode_list'])->name('admin_pincode.list');
Route::get('city_list', [AdminController::class,'city_list'])->name('admin_city.list');

Route::get('contact_us', [AdminController::class,'contact_us'])->name('admin.contact_us');

Route::get('/change_theme', [AdminController::class,'change_theme'])->name('change_theme');

Route::get('/logout', [AdminController::class,'adminlogout'])->name('admin_logout');

Route::post('attempt-login', [AdminController::class, 'attemptLogin'])->name('admin.login');

Route::get('vendor-comission-percentage', [VendorController::class,'vendor_comission_percentage'])->name('vendor_comission_percentage');
Route::get('vendor-comission-percentage-add', [VendorController::class,'vendor_comission_percentage_add'])->name('vendor_comission_percentage_add');

Route::get('get_category_by_vendor', [VendorController::class,'get_category_by_vendor'])->name('get_category_by_vendor');
Route::get('get_sub_category_by_category', [SubCategoryController::class,'get_sub_category_by_category'])->name('get_sub_category_by_category');

Route::get('get_service_category_by_vendor', [VendorController::class,'get_service_category_by_vendor'])->name('get_service_category_by_vendor');
Route::get('get_service_sub_category_by_category', [ServiceSubCategoryController::class,'get_service_sub_category_by_category'])->name('get_service_sub_category_by_category');

Route::group(['middleware' => ['admin']], function() {

    Route::get('/dashboard', [AdminController::class,'dashboard'])->name('admin.dashboard');

    Route::get('/admin_password', function () {  return view('backend.password_change'); })->name('admin.password');
    Route::post('password/update', [AdminController::class, 'password_update'])->name('admin.password_update');

    Route::get('customer-list', [CustomerController::class,'index'])->name('customer_list');
    Route::get('customer-create', [CustomerController::class,'create'])->name('customer_create');
    Route::get('customer-edit/{id}', [CustomerController::class,'edit'])->name('customer_edit');
    Route::get('customer-profile/{id}', [CustomerController::class,'customer_profile'])->name('customer_profile');
    Route::get('customer-view/{id}', [CustomerController::class,'customer_view'])->name('customer_view');
    Route::get('customer-e_puja_order/{id}', [CustomerController::class,'customer_e_puja'])->name('customer_e_puja');

    Route::post('customer/add', [CustomerController::class, 'store'])->name('customer.store');
    Route::post('customer/update', [CustomerController::class, 'update'])->name('customer.update');
    Route::post('customer/update-status', [CustomerController::class, 'updateStatus'])->name('customer.update_status');
    Route::get('/customer_data',[CustomerController::class, "get_customer"])->name('get_customer');
    Route::get('customer-order/{id}', [CustomerController::class,'customer_order'])->name('customer_order');
    Route::get('customer-oneday-order/{id}', [CustomerController::class,'customer_oneday_order'])->name('customer_oneday_order');

    Route::get('customer/pay/{id}/{m_id}', [CustomerController::class, 'admin_pay'])->name('admin_customer_pay');

    Route::get('pujari-list', [PujariController::class,'index'])->name('pujari_list');
    Route::get('verified-pujari-list', [PujariController::class,'verified_pujari_list'])->name('verified_pujari_list');
    Route::get('unverified-pujari-list', [PujariController::class,'unverified_pujari_list'])->name('unverified_pujari_list');
    Route::get('pujari-create', [PujariController::class,'create'])->name('pujari_create');
    Route::get('pujari-edit/{id}', [PujariController::class,'edit'])->name('pujari_edit');
    Route::get('pujari-delete/{id}', [PujariController::class,'delete'])->name('pujari_delete');
    Route::get('pujari-view/{id}', [PujariController::class,'vendor_view'])->name('pujari_view');
    Route::post('pujari/add', [PujariController::class, 'store'])->name('pujari.store');
    Route::post('pujari/update', [PujariController::class, 'update'])->name('pujari.update');
    Route::post('pujari/update-status', [PujariController::class, 'updateStatus'])->name('pujari.update_status');
    Route::post('pujari/update-verified', [PujariController::class, 'updateVerified'])->name('pujari.update_verified');
    Route::post('pujari/update-online', [PujariController::class, 'updateOnline'])->name('pujari.update_online');
    Route::get('/pujari_data',[PujariController::class, "get_pujari"])->name('get_pujari');
    Route::get('/verified_pujari_data',[PujariController::class, "get_pujari_verified"])->name('get_pujari_verified');
    Route::get('/unverified_pujari_data',[PujariController::class, "get_pujari_unverified"])->name('get_pujari_unverified');

    Route::post('pujari_profile_update', [PujariController::class, 'profile_update'])->name('pujari_profile_update');
    Route::post('pujari/bank_update', [PujariController::class, 'bank_update'])->name('pujari_bank_update');
    Route::post('pujari/education_update', [PujariController::class, 'education_update'])->name('pujari_education_update');

    Route::post('vendor_registration_fess/{id}', [PujariController::class, 'vendor_registration_fess'])->name('admin.pay_registration_fee');
    Route::post('vendor_categories_prdouct_fess/{id}', [PujariController::class, 'vendor_categories_product_fess'])->name('admin.pay_vendor_categories_product_fess');
    Route::post('vendor_categories_service_fess/{id}', [PujariController::class, 'vendor_categories_service_fess'])->name('admin.pay_vendor_categories_service_fess');

    Route::resource('business-category', BusinessCategoryController::class);
    Route::post('business-category/update-featured', [BusinessCategoryController::class, 'updateFeatured'])->name('business_category.update_featured');
    Route::post('business-category/update-status', [BusinessCategoryController::class, 'updateStatus'])->name('business_category.update_status');
    Route::get('/business_category_data',[BusinessCategoryController::class, "get_business"])->name('business_category_get_data');
    Route::get('/business_category/edit/{id}',[BusinessCategoryController::class, "edit"])->name('business_category_edit');
    Route::get('business_category-view/{id}', [BusinessCategoryController::class,'view'])->name('business_category_view');

    //Gallery
    Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');

    Route::get('/gallery/create', [GalleryController::class, 'create'])->name('gallery.create');
    Route::post('/gallery/store', [GalleryController::class, 'store'])->name('gallery.store');
    Route::get('/gallery/{gallery}/edit', [GalleryController::class, 'edit'])->name('gallery.edit');
    Route::put('/gallery/{gallery}', [GalleryController::class, 'update'])->name('gallery.update');
    Route::get('/gallery/delete/{gallery}',[GalleryController::class, 'destroy'])->name('gallery.delete');

    //Category
    Route::resource('category', CategoryController::class);
    Route::post('category/update-featured', [CategoryController::class, 'updateFeatured'])->name('category.update_featured');
    Route::post('category/update-status', [CategoryController::class, 'updateStatus'])->name('category.update_status');
    Route::post('category/priority', [CategoryController::class, 'priority'])->name('category.update_priority');
    Route::get('/category_data',[CategoryController::class, "get_category"])->name('category_get_data');
    Route::get('/category/edit/{id}',[CategoryController::class, "edit"])->name('category_edit');
    Route::get('/category/view/{id}',[CategoryController::class, "view"])->name('category_view');
    // temple-puja
    Route::resource('temple_puja', TemplePujaController::class);
    Route::post('temple_puja/update-featured', [TemplePujaController::class, 'updateFeatured'])->name('temple_puja.update_featured');
    Route::post('temple_puja/update-upcoming', [TemplePujaController::class, 'updateUpcoming'])->name('temple_puja.update_upcoming');
    Route::post('temple_puja/update-status', [TemplePujaController::class, 'updateStatus'])->name('temple_puja.update_status');
    Route::get('/temple_puja_data',[TemplePujaController::class, 'get_product'])->name('temple_puja_get_data');
    Route::get('/temple_puja/edit/{id}',[TemplePujaController::class, 'edit'])->name('temple_puja_edit');
    Route::get('/temple_puja/view/{id}',[TemplePujaController::class, 'view'])->name('temple_puja_view');
    Route::get('/temple_puja/package/add/{id}',[TemplePujaController::class, 'package_add'])->name('temple_puja.package_add');
    Route::post('temple_puja/package/update', [TemplePujaController::class, 'package_update'])->name('temple_puja.package_update');
    Route::get('/temple_puja/package_view/{id}',[TemplePujaController::class, 'product_package'])->name('temple_puja_package');
    Route::get('/temple_puja_package_edit/{id}',[TemplePujaController::class, 'product_package_edit'])->name('temple_puja_package_edit');
    Route::post('temple_puja_package_update', [TemplePujaController::class, 'product_package_update'])->name('temple_puja_package_update');
    Route::get('/temple_puja_package_delete/{id}',[TemplePujaController::class, 'product_package_delete'])->name('temple_puja_package_delete');
    // E-puja
    Route::resource('e_puja', EPujaController::class);
    Route::post('e_puja/update-featured', [EPujaController::class, 'updateFeatured'])->name('e_puja.update_featured');
    Route::post('e_puja/update-upcoming', [EPujaController::class, 'updateUpcoming'])->name('e_puja.update_upcoming');
    Route::post('e_puja/update-status', [EPujaController::class, 'updateStatus'])->name('e_puja.update_status');
    Route::get('/e_puja_data',[EPujaController::class, 'get_product'])->name('e_puja_get_data');
    Route::get('/e_puja/edit/{id}',[EPujaController::class, 'edit'])->name('e_puja_edit');
    Route::get('/e_puja/view/{id}',[EPujaController::class, 'view'])->name('e_puja_view');
    Route::get('/e_puja/package/{id}',[EPujaController::class, 'package_add'])->name('e_puja_package_add');
    Route::post('e_puja/package_update', [EPujaController::class, 'package_update'])->name('e_puja.package_update');
    Route::get('/e_puja/package_view/{id}',[EPujaController::class, 'product_package'])->name('e_puja_package');
    Route::get('/e_puja_package_edit/{id}',[EPujaController::class, 'product_package_edit'])->name('e_puja_package_edit');
    Route::post('e_puja_package_update', [EPujaController::class, 'product_package_update'])->name('e_puja_package_update');
    Route::get('/e_puja_package_delete/{id}',[EPujaController::class, 'product_package_delete'])->name('e_puja_package_delete');
    Route::get('/e_puja/e_puja_inclusion/{id}',[EPujaController::class, 'e_puja_inclusion'])->name('e_puja.inclusion');
    Route::post('/e_puja/e_puja_inclusion_add',[EPujaController::class, 'e_puja_inclusion_add'])->name('e_puja_inclusion_add');
    Route::post('/e_puja/inclusion-list',[PoojaController::class, 'inclusion_list'])->name('inclusion_list');

    Route::get('/e_puja_upcoming',[EPujaController::class, 'e_puja_upcoming'])->name('e_puja_upcoming');
    Route::get('/e_puja_upcoming_data',[EPujaController::class, 'get_upcoming'])->name('get_upcoming');

    Route::get('/e_puja_completed',[EPujaController::class, 'e_puja_completed'])->name('e_puja_completed');
    Route::get('/e_puja_completed_data',[EPujaController::class, 'get_completed'])->name('get_completed');

    // All Puja
    Route::resource('admin_product', ProductController::class);
    Route::post('admin_product/update-featured', [ProductController::class, 'updateFeatured'])->name('admin_product.update_featured');
    Route::post('admin_product/update-upcoming', [ProductController::class, 'updateUpcoming'])->name('admin_product.update_upcoming');
    Route::post('admin_product/update-status', [ProductController::class, 'updateStatus'])->name('admin_product.update_status');
    Route::get('/admin_product_data',[ProductController::class, 'get_product'])->name('admin_product_get_data');
    Route::get('/admin_product/edit/{id}',[ProductController::class, 'edit'])->name('admin_product_edit');
    Route::get('/admin_product/view/{id}',[ProductController::class, 'view'])->name('admin_product_view');
    Route::get('/package_add/{id}',[ProductController::class, 'package_add'])->name('admin_package_add');
    Route::post('admin_product/package_update', [ProductController::class, 'package_update'])->name('admin_product.package_update');
    Route::get('/product_package/{id}',[ProductController::class, 'product_package'])->name('admin_product_package');
    Route::get('/product_package_edit/{id}',[ProductController::class, 'product_package_edit'])->name('product_package_edit');
    Route::post('admin_product_package_update', [ProductController::class, 'admin_product_package_update'])->name('admin_product_package_update');
    Route::get('/product_package_delete/{id}',[ProductController::class, 'product_package_delete'])->name('product_package_delete');

    Route::resource('slider', SliderController::class);
    Route::post('slider/update-status', [SliderController::class, 'updateSliderStatus'])->name('slider.update_status');

    Route::resource('banner', BannerController::class);
    Route::post('banner/update-status', [BannerController::class, 'updateBannerStatus'])->name('banner.update_status');

    Route::resource('blog', BlogController::class);
    Route::post('blog/update-status', [BlogController::class, 'updateBlogStatus'])->name('blog.update_status');

    Route::resource('testimonial', TestimonialController::class);
    Route::post('testimonial/update-status', [TestimonialController::class, 'updateTestimonialStatus'])->name('testimonial.update_status');

    Route::resource('puja-benifits', PujaBenifitController::class);
    Route::get('/puja-benifits/create/data/{id}',[PujaBenifitController::class, "create"])->name('puja_benifit_create');
    Route::resource('temple-details', TempleDetailController::class);
    Route::get('/temple-details/create/data/{id}',[TempleDetailController::class, "create"])->name('temple_detail_create');

    Route::resource('enquiry', EnquiryController::class);
    Route::get('/enquiry-delete/{id}', [EnquiryController::class, 'destroy'])->name('enquiry_delete');
    Route::get('/enquiry_data',[EnquiryController::class, "get_enquiry"])->name('enquiry_get_data');
    Route::get('/enquiry/view/{id}',[EnquiryController::class, 'view'])->name('enquiry_view');

    Route::get('/product_enquiry', [EnquiryController::class, 'product_enquiry'])->name('product_enquiry');
    Route::get('/product_enquiry_data',[EnquiryController::class, "get_product_enquiry"])->name('product_enquiry_get_data');

    Route::resource('review', ReviewController::class);
    Route::get('/review/delete/{id}',[ReviewController::class,'destroy'])->name('review.delete');

    Route::post('review-status-update', [ReviewController::class, 'updateStatus'])->name('review.status_update');

    Route::resource('kundali', KundaliController::class);

    Route::resource('app_setup', AppSetupController::class);
    Route::resource('policy', PolicyController::class);

    Route::post('admin_projects/media', [ProductController::class, 'storeMedia'])->name('admin_projects.storeMedia');

    Route::get('order', [OrderController::class, 'admin_order'])->name('admin.orders');
    Route::get('one_day_order', [OrderController::class, 'admin_one_day_order'])->name('admin.one_day_orders');
    Route::get('order/show/{id}', [OrderController::class, 'admin_order_details'])->name('admin.order_show');
    Route::get('one_day_order/show/{id}', [OrderController::class, 'admin_one_day_order_details'])->name('admin.one_day_order_show');
    Route::get('service_order', [OrderController::class, 'admin_service_order'])->name('admin.service_orders');
    Route::get('service_order/show/{id}', [OrderController::class, 'admin_service_order_details'])->name('vendor.service_order_show');
    Route::get('today-order', [OrderController::class, 'today_order'])->name('today.order');
    Route::get('today_order/report', [OrderController::class, 'today_order_report'])->name('admin.today_order_report');
    Route::get('delivery_boy_order/report', [OrderController::class, 'delivery_boy_order_report'])->name('admin.delivery_boy_order_report');
    Route::post('status-update', [OrderController::class, 'status_update'])->name('status.update');
    Route::post('pujari-ji-update', [OrderController::class, 'pujariji_update'])->name('status.pujariji_update');
    Route::post('pujari_model', [OrderController::class, 'pujari_model'])->name('pujari_model');
    Route::get('order_payment_transaction/{id}', [OrderController::class, 'order_payment_transaction'])->name('order.payment_transaction');
    Route::post('order_payment_add', [OrderController::class, 'order_payment_add'])->name('order_payment_add');
    Route::post('order_payment_status_update', [OrderController::class, 'order_payment_status_update'])->name('order_payment_status_update');
    Route::get('invoice/{id}',[OrderController::class,'invoice'])->name('order.invoice');
    Route::get('one_day_order_invoice/{id}',[OrderController::class,'one_day_order_invoice'])->name('one_day_order_invoice.invoice');
    Route::post('pujari_comission', [OrderController::class, 'pujari_comission'])->name('pujari_comission');


    Route::get('pos', [PosController::class, 'admin_pos'])->name('admin.pos');

    Route::resource('delivery-boy', DeliveryBoyController::class);
    Route::get('/delivery_boy_data',[DeliveryBoyController::class, "get_delivery_boy"])->name('delivery_boy_get_data');
    Route::get('/delivery-boy/edit/{id}',[DeliveryBoyController::class, "edit"])->name('delivery_boy_edit');
    Route::post('delivery-boy/update-status', [DeliveryBoyController::class, 'updateDeliveryBoyStatus'])->name('delivery_boy.update_status');


    Route::post('admin_projects/media_service', [ServiceController::class, 'storeMedia'])->name('admin_projects.storeMedia_service');

    Route::get('/service_city',[AdminController::class,'service_city'])->name('admin.service_city');
    Route::post('service_city/update-status', [AdminController::class, 'updateServiceCityStatus'])->name('service_city.update_status');
    Route::post('service_city/store', [AdminController::class, 'serviceCityStore'])->name('service_city.store');
    Route::get('service_city-edit/{id}', [AdminController::class,'editServiceCity'])->name('service_city.edit');
    Route::get('service_city-delete/{id}', [AdminController::class,'deleteServiceCity'])->name('service_city.delete');

    Route::get('/terth_city',[AdminController::class,'terth_city'])->name('admin.terth_city');
    Route::post('terth_city/update-status', [AdminController::class, 'updateTerthCityStatus'])->name('terth_city.update_status');
    Route::post('terth_city/store', [AdminController::class, 'terthCityStore'])->name('terth_city.store');
    Route::get('terth_city-edit/{id}', [AdminController::class,'editTerthCity'])->name('terth_city.edit');
    Route::get('terth_city-delete/{id}', [AdminController::class,'deleteterthCity'])->name('terth_city.delete');

    Route::get('/pincode',[AdminController::class,'pincode'])->name('admin.pincode');
    Route::post('pincode/update-status', [AdminController::class, 'updatePincodeStatus'])->name('pincode.update_status');
    Route::post('pincode/store', [AdminController::class, 'pincodeStore'])->name('pincode.store');
    Route::get('pincode-edit/{id}', [AdminController::class,'editPincode'])->name('pincode.edit');
    Route::get('pincode-delete/{id}', [AdminController::class,'deletePincode'])->name('pincode.delete');

    Route::post('get-cities', [AdminController::class, 'getCities'])->name('get-cities');
    Route::post('get-pincode', [AdminController::class, 'getPincode'])->name('get-pincode');

    Route::get('/language',[AdminController::class,'language'])->name('admin.language');
    Route::post('language/update-status', [AdminController::class, 'updateLanguageStatus'])->name('language.update_status');
    Route::post('language/store', [AdminController::class, 'languageStore'])->name('language.store');
    Route::get('language-edit/{id}', [AdminController::class,'editLanguage'])->name('language.edit');
    Route::get('language-delete/{id}', [AdminController::class,'deleteLanguage'])->name('language.delete');

    Route::resource('our_pujari', OurPujariController::class);
    Route::get('/our_pujari/delete/{id}',[OurPujariController::class,'destroy'])->name('our_pujari.delete');
    Route::get('/setting',[AdminController::class,'setting'])->name('admin.setting');
    Route::post('/setting/update',[AdminController::class,'setting_update'])->name('admin.setting.update');


    Route::get('/pay_gv_wallet',[AdminController::class,'pay_gv_wallet'])->name('admin.pay_gv_wallet');
    Route::get('/give_reward',[AdminController::class,'give_reward'])->name('admin.give_reward');

    Route::get('/withdrwal_request',[AdminController::class,'withdrwal_request'])->name('admin.withdrwal_request');
    Route::get('/customer_pay/{id}',[AdminController::class,'customer_pay'])->name('admin.customer_pay');

    Route::get('/reward',[AdminController::class,'reward'])->name('admin.reward');
    Route::get('/reward_user',[AdminController::class,'reward_user'])->name('admin.reward_user');
    Route::get('/reward_achive_user',[AdminController::class,'reward_achive_user'])->name('admin.reward_achive_user');
    Route::get('/bonanza_reward_user',[AdminController::class,'bonanza_reward_user'])->name('admin.bonanza_reward_user');

    Route::get('/top-achivers',[AdminController::class,'top_achiver'])->name('admin.top_achiver');
    Route::post('/top-achivers/store',[AdminController::class,'top_achiver_store'])->name('top_achiver.store');
    Route::get('top-achiver-edit/{id}', [AdminController::class,'top_achiver_edit'])->name('top_achiver.edit');
    Route::get('top-achiver-delete/{id}', [AdminController::class,'top_achiver_delete'])->name('top_achiver.delete');

    Route::get('/vendor-registration-report', [ReportController::class, 'vendor_recharge_report'])->name('admin.report.vendor_recharge_report');
    Route::get('/get_vendor_registration_report',[ReportController::class, "get_vendor_recharge_report"])->name('admin_get_vendor_recharge_report');

    Route::get('/customer-registration-report', [ReportController::class, 'customer_recharge_report'])->name('admin.report.customer_recharge_report');
    Route::get('/get_customer_registration_report',[ReportController::class, "get_customer_recharge_report"])->name('admin_get_customer_recharge_report');

    Route::get('/tds-report', [ReportController::class, 'tds_report'])->name('admin.report.tds_report');
    Route::get('/get_tds_report',[ReportController::class, "get_tds_report"])->name('admin_get_tds_report');

    Route::get('/genial_t-report', [ReportController::class, 'genial_t_report'])->name('admin.report.genial_t_report');
    Route::get('/get_genial_t_report',[ReportController::class, "get_genial_t_report"])->name('admin_get_genial_t_report');

    Route::get('/customer-report', [ReportController::class, 'customer_report'])->name('admin.report.customer_report');
    Route::get('/get_customer_report',[ReportController::class, "get_customer_report"])->name('admin_get_customer_report');

    Route::get('/vendor-report', [ReportController::class, 'vendor_report'])->name('admin.report.vendor_report');
    Route::get('/get_vendor_report',[ReportController::class, "get_vendor_report"])->name('admin_get_vendor_report');
    Route::get('/vendor-report-detail/{id}', [ReportController::class, 'vendor_report_detail'])->name('admin.report.vendor_report_detail');

    Route::get('/credit_sale-report', [ReportController::class, 'credit_sale_report'])->name('admin.report.credit_sale_report');

    Route::get('/gp-report', [ReportController::class, 'gp_report'])->name('admin.report.gp_report');
    Route::get('/get_gp_report',[ReportController::class, "get_gp_report"])->name('admin_get_gp_report');

    Route::get('/vendor_sale-report', [ReportController::class, 'vendor_sale_report'])->name('admin.report.vendor_sale_report');
    Route::get('/get_vendor_sale_report',[ReportController::class, "get_vendor_sale_report"])->name('admin_get_vendor_sale_report');

    Route::get('/genial_income-report', [ReportController::class, 'genial_income_report'])->name('admin.report.genial_income_report');
    Route::get('/get_genial_income_report',[ReportController::class, "get_genial_income_report"])->name('admin_get_genial_income_report');


    Route::get('/seller_pay/{id}',[AdminController::class,'seller_pay'])->name('admin.seller_pay');

    Route::get('/vendor-recharge-report', [ReportController::class, 'vendor_rechargeReport'])->name('admin.report.vendor_rechargeReport');
    Route::get('/get_vendor_recharge_report',[ReportController::class, "get_vendor_rechargeReport"])->name('admin_get_vendor_rechargeReport');

    Route::get('/check_status_for_payment/{id}',[AdminController::class,'check_status_for_payment'])->name('admin.check_status_for_payment');

    Route::resource('roles', RoleController::class);
    Route::resource('staff', StaffController::class);

    Route::get('/poiner_view_all', [AdminController::class,'poiner_view_all'])->name('admin.poiner_view_all');
    Route::get('/get_poiner', [AdminController::class,'get_poiner'])->name('admin_get_poiner');

    Route::get('/leader_view_all', [AdminController::class,'leader_view_all'])->name('admin.leader_view_all');
    Route::get('/get_leader', [AdminController::class,'get_leader'])->name('admin_get_leader');

    Route::get('/rapid_view_all', [AdminController::class,'rapid_view_all'])->name('admin.rapid_view_all');
    Route::get('/get_rapid', [AdminController::class,'get_rapid'])->name('admin_get_rapid');

    Route::get('/president_view_all', [AdminController::class,'president_view_all'])->name('admin.president_view_all');
    Route::get('/get_president', [AdminController::class,'get_president'])->name('admin_get_president');
    Route::get('/sorting-settings', [AdminController::class, 'showSortingSettings'])->name('sorting.settings.show');
    Route::post('/sorting-settings', [AdminController::class, 'updateSortingSetting'])->name('sorting.settings.update');
    Route::resource('pages', App\Http\Controllers\Admin\PageController::class);
});
