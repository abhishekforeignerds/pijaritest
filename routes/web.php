<?php



use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
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

//Route::get('/', [AdminController::class,'adminLogin'])->name('admin_login');
Route::get('/', [FrontendController::class,'index'])->name('index');
Route::get('/contact-us', [FrontendController::class,'contact_us'])->name('contact_us');
Route::get('/about-us', [FrontendController::class,'about'])->name('about');
Route::get('/e-puja', [FrontendController::class,'one_day_puja'])->name('one-day-puja');
Route::get('/e-puja/{slug}', [FrontendController::class,'one_day_puja_details'])->name('one-day-puja.details');
Route::get('e-puja/package/{id}', [FrontendController::class,'one_day_package'])->name('one_day_product_package');
Route::get('e-puja/puja/package/checkout', [FrontendController::class,'one_day_package_checkout'])->name('one_day_product_package.checkout');
Route::get('/teerth-puja-city', [FrontendController::class,'teerth_puja_city'])->name('teerth-puja-city');
Route::get('/teerth-puja', [FrontendController::class,'teerth_puja'])->name('teerth_puja');
Route::get('/astrology', [FrontendController::class,'astrology'])->name('astrology');
Route::post('astrology', [FrontendController::class,'astrologySave'])->name('astrology.save');
Route::get('/how-we-work', [FrontendController::class,'howWork'])->name('how-work');
Route::post('/enquiry/store', [FrontendController::class,'enquiry_store'])->name('enquiryStore');
Route::post('/save_enquiry_data', [FrontendController::class,'save_enquiry_data'])->name('save_enquiry_data');
Route::get('/terms', [FrontendController::class,'terms'])->name('terms');
Route::get('/privacy', [FrontendController::class,'privacy'])->name('privacy');
Route::get('/return', [FrontendController::class,'return'])->name('return');
Route::get('/shipping', [FrontendController::class,'shipping'])->name('shipping');
Route::get('/blog', [FrontendController::class,'blog'])->name('blog');
Route::get('/blogs/{slug}', [FrontendController::class,'viewblog'])->name('blogs');

Route::get('/login', [FrontendController::class,'customer_login'])->name('login');
Route::get('/logout', [FrontendController::class,'attemptLogout'])->name('logout');

Route::get('/pujari-login', [FrontendController::class,'pujari_login'])->name('pujari-login');
Route::get('/listing', [FrontendController::class,'listing'])->name('listing');
Route::get('/puja', [FrontendController::class,'all_puja'])->name('puja');
Route::get('/details/{slug}', [FrontendController::class,'product_details'])->name('details');
Route::get('/package/{slug}', [FrontendController::class,'product_package'])->name('product_package');
Route::post('/review-rating', [FrontendController::class,'reviewSubmit'])->name('review_rating');
Route::get('/set_location', [FrontendController::class,'set_location'])->name('set_location');
Route::get('/set_pooja_language', [FrontendController::class,'set_pooja_language'])->name('set_pooja_language');
Route::get('/set_city', [FrontendController::class,'set_city'])->name('set_city');
Route::get('/set_language', [FrontendController::class,'set_language'])->name('set_language');

Route::post('send_otp',[FrontendController::class, 'send_otp'])->name('send_otp');
Route::post('check_otp',[FrontendController::class, 'check_otp'])->name('check_otp');
Route::post('send_regsiter_otp',[FrontendController::class, 'send_regsiter_otp'])->name('send_regsiter_otp');



Route::post('customer-login', [FrontendController::class, 'attemptLogin'])->name('customer.login');

Route::get('/availability/{slug}', [FrontendController::class,'date_availability'])->name('availability');

Route::get('/cart', [FrontendController::class,'cart'])->name('cart');
Route::get('/checkout', [FrontendController::class,'checkout'])->name('checkout');

Route::delete('/cart/remove/{id}', [FrontendController::class, 'cart_remove'])->name('cart.remove');

Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');

Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');
Route::post('/oneday_order/store', [OrderController::class, 'oneday_order_store'])->name('oneday_order.store');
Route::get('/order/confirmation/{id}', [OrderController::class,'order_confirmation'])->name('order_confirmation');
Route::get('/one-day-order/confirmation/{id}', [OrderController::class,'one_day_order_confirmation'])->name('one_day_order.confirmation');
Route::post('/get_razorpay_order_id', [FrontendController::class, 'get_razorpay_order_id'])->name('get_razorpay_order_id');


 Route::post('get-pincode', [FrontendController::class, 'getPincode'])->name('get-pincodes');

Route::get('panchang', App\Http\Livewire\PanchangLivewire::class)->name('panchang');
Route::get('daily-horoscope', App\Http\Livewire\DailyHoroscopeLivewire::class)->name('daily-horoscope');
Route::get('weekly-horoscope', App\Http\Livewire\WeeklyHoroscopeLivewire::class)->name('weekly-horoscope');
Route::get('yearly-horoscope', App\Http\Livewire\YearlyHoroscopeLivewire::class)->name('yearly-horoscope');

Route::get('search-place', [FrontendController::class, 'searchPlace'])->name('search.place');

Route::group(['middleware' => ['auth']], function() {


    Route::get('/dashboard', [FrontendController::class,'user_dashboard'])->name('dashboard');
    Route::get('/customer_order', [OrderController::class,'customer_order'])->name('user.customer_order');
    Route::get('/customer_order_show/{id}', [OrderController::class,'customer_order_details'])->name('user.customer_order_show');

    Route::get('/customer_e_puja_order', [OrderController::class,'customer_e_puja_order'])->name('user.customer_e_puja_order');
    Route::get('/customer_e_puja_order_show/{id}', [OrderController::class,'customer_e_puja_order_details'])->name('user.customer_e_puja_order_show');

    Route::get('/profile', function () {  return view('user_dashboard.customer.profile'); })->name('customer.profile');
    Route::post('profile/update', [CustomerController::class, 'profile_update'])->name('customer.profile_update');

});





