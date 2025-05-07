<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Blog;
use App\Models\Cart;
use App\Models\User;
use Razorpay\Api\Api;
use App\Models\Policy;
use App\Models\Pujari;
use App\Models\Review;
use App\Models\Slider;
use GuzzleHttp\Client;
use App\Models\Enquiry;
use App\Models\Kundali;
use App\Models\Package;
use App\Models\Pincode;
use App\Models\Product;
use App\Models\Category;
use App\Models\Language;
use App\Models\Inclusion;
use App\Models\OurPujari;
use App\Models\Page;
use App\Models\PujaBenifit;
use App\Models\ServiceCity;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use App\Models\TempleDetails;
use App\Models\TerthPujaCity;
use App\Models\ProductEnquiry;
use App\Models\SortingSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class FrontendController extends Controller
{
    public function index(Request $request){
        $currentPath = $request->path();
        $page = Page::where('slug', $currentPath)->firstOrFail();
        if($page){
            $pagetitle= $page->title;
            $pagedescription = $page->description;
        }else{
            $pagetitle= '';
            $pagedescription = '';
        }
       
  
        $sliders = Slider::where('status', '1')->get();

        $setting = SortingSetting::getSettingFor('Product');

        $upcoming_pooja = Product::where('upcoming', '1')
            ->where('product_type', 'all')
            ->orderBy($setting->sort_column, $setting->sort_direction)
            ->paginate(10);

        $our_pujari = OurPujari::latest()->paginate(10);
        $upcoming_epooja = Product::where('upcoming', '1')->where('product_type','one_day')->latest()->paginate(10);
        $blogs = Blog::query()->where('status','1')->latest()->paginate(10);
        $testimonials = Testimonial::where('type','text')->latest()->paginate(10);
        $video_testimonials = Testimonial::where('type','video')->where('page','home')->latest()->paginate(10);
        $products = Product::where('status', '1')->with('category')->take(12)->inRandomOrder()->get();
        $our_pujari = OurPujari::latest()->paginate(10);

        $allProducts = Product::where('status',1)->where('product_type','all');
        if(!empty($request->city)){
            session()->put('city', $request->city);
            Session::forget('user_location');
            $city=ServiceCity::where('city',$request->city)->first();
        }
        if(!empty($request->language)){
            session()->put('language', $request->language);
            $language=Language::where('language',$request->language)->first();
            $allProducts=$allProducts->whereJsonContains('language',''.$language->id);

        }
        if(!empty($request->category)){
            $category=Category::where('slug',$request->category)->first();
            $allProducts=$allProducts->where('category_id',$category->id);
        }

        if($request->search){
            $allProducts=$allProducts->where('name','like','%'.$request->search.'%');
        }
        $allProducts=$allProducts->get();
        Session::forget('user_location');
        return view('frontend.index', compact('sliders','products','blogs', 'upcoming_pooja', 'our_pujari', 'testimonials', 'video_testimonials','upcoming_epooja', 'allProducts','pagetitle','pagedescription'));

    }

    public function enquiry_store(Request $request)
    {
        $enquiry = new Enquiry;
        $enquiry->name = $request->name;
        $enquiry->phone = $request->phone;
        $enquiry->email = $request->email;
        $enquiry->message = $request->message;
        $enquiry->save();

        return back()->with('success','Enquiry Send Successfully!');
    }

    public function save_enquiry_data(Request $request){

        $check_user=Auth::check();

        if($check_user)
        {
            $user_id=Auth::user()->id;
        }
        else
        {
            $check_session=Session::get('guest_id');
            if($check_session)
            {
                $user_id=$check_session;
            }
            else
            {
                $random_number=time().rand(1, 100);
                Session::put('guest_id','guest_'.$random_number);
                $user_id='guest_'.$random_number;
            }
        }
        $product=Product::find($request->product_id);

        $enquiry = new ProductEnquiry;
        $enquiry->name = $request->name;

        $enquiry->phone = $request->phone;
        $enquiry->product_id = $request->product_id;
        $enquiry->package_id = $request->package_id;
        $enquiry->user_id = $user_id;
        $enquiry->save();

        return response()->json(['status' => true, 'message' => 'Enquiry Send Successfully!','product'=>$product]);
    }

    public function about(){
        return view('frontend.about', ["page_title" => "About Us"]);
    }
    public function contact_us(){
        return view('frontend.contact_us', ["page_title" => "Contact Us"]);
    }

    public function teerth_puja_city(){
      $products = Product::where('status', 1)
        ->where('product_type', 'temple')
        ->get(['city']);
      $cityIds = $products->pluck('city')->toArray();
      $cityArray=[];
      foreach($cityIds as $city){
        foreach(json_decode($city) as $ct){
            if (!in_array($ct, $cityArray)) {
                array_push($cityArray,$ct);
            }
        }
      }
        $city=TerthPujaCity::whereIn('id',$cityArray)->where('status','active')->get();
        $video_testimonials = Testimonial::where('type','video')->where('page','terth_pooja')->latest()->paginate(10);
        return view('frontend.teerth_puja_city', [ "page_title" => "Teerth Puja City", "city" => $city,"video_testimonials"=>$video_testimonials]);
    }

    public function teerth_puja(Request $request){
        // $id=TerthPujaCity::where('city',$request->city)->first();
        //     session()->put('city', $request->city);
        //     Session::forget('user_location');
        $products = Product::where('status', 1)->where('product_type', 'temple');
        // if(!empty($id->id)){
        //     $products=$products->whereJsonContains('city',''.$id->id);
        // }
        if($request->search){
            $products=$products->where('name','like','%'.$request->search.'%')->orWhere('name_hindi','like','%'.$request->search.'%');
        }
        $products = $products->get();
         $city_name='';
        // if(session()->get('pooja_language') == 'English'){
        //     $city_name=$id->city;
        // }else{
        //     $city_name=$id->city_hindi;
        // }


        return view('frontend.teerth_puja', [ "page_title" => "Teerth Puja", "products" => $products,"city"=>$city_name
        ]);
    }

    public function astrology(){
        return view('frontend.astrology', ["page_title" => "Astrology"]);
    }

    public function astrologySave(Request $request)
    {
        $request->validate([
            'name'      => 'required',
            'package_id'=> 'required',
            'phone'     => 'required',
            'dob'       => 'required',
            'tob'       => 'required',
            'pob'       => 'required',
            'language'  => 'required',
            'pdf_type'  => 'required',
            'address'   => 'required',
        ]);

        $data = new Kundali;
        $data->package_id = $request->package_id;
        $data->name = $request->name;
        $data->phone = $request->phone;
        $data->dob = $request->dob;
        $data->tob = $request->tob;
        $data->pob = $request->pob;
        $data->language = $request->language;
        $data->pdf_type = $request->pdf_type;
        $data->address = $request->address;
        $data->save();
        return redirect()->route('astrology')->with('success', 'Your astrological result has been submitted successfully.');
    }

    public function howWork(){
        $content = Policy::first();
        return view('frontend.how_we_work', compact('content'), ["page_title" => "How We Work"]);
    }

    public function terms(){
        $content = Policy::first();
        return view('frontend.terms', compact('content'), ["page_title" => "Terms & Policy"]);
    }

    public function privacy(){
        $content = Policy::first();
        return view('frontend.privacy', compact('content'), ["page_title" => "Privacy Policy"]);
    }

    public function return(){
        $content = Policy::first();
        return view('frontend.return', compact('content'), ["page_title" => "Return Policy"]);
    }

    public function shipping(){
        $content = Policy::first();
        return view('frontend.shipping', compact('content'), ["page_title" => "Shipping Policy"]);
    }


    public function customer_login(){
        if (Auth::check()) {
            return redirect()->intended(route('dashboard'));
        }
        return view('frontend.login');
    }

    public function pujari_register(){
        return view('frontend.pujari-register');
    }

    public function pujari_login(){
        return view('frontend.pujari-login');
    }

    public function blog()
    {
        $blogs = Blog::orderBy('id', 'desc')
                     ->where('status', '1')
                     ->get();
    
        $video_testimonials = Testimonial::where('type', 'video')
                                         ->where('page', 'e_puja')
                                         ->latest()
                                         ->paginate(10);
    
        // Correct compact syntax: two separate strings
        return view('frontend.blog', compact('blogs', 'video_testimonials'));
    }
    

    public function viewblog($slug)
    {
        $blog = Blog::where('slug', $slug)->first();
        return view('frontend.showblog', compact('blog'));
    }

    public function date_availability(Request $request,$slug)
    {
        $check_user=Auth::check();

        $user_id = null;

        if($check_user)
        {
            $user_id=Auth::user()->id;
        }
        else
        {
            $check_session=Session::get('guest_id');
            if($check_session)
            {
                $user_id=$check_session;
            }
        }

        $check_for_cart=Cart::where('user_id',$user_id)->first();
      if(!empty($check_for_cart->id)){

        if(session()->get('user_location')=='home'){
            $is_available='';
        }else{
            $is_available='no';
        }
        $product = Product::where('slug',$slug)->first();
        $packages=Package::where('product_id',$product->id)->get();

        if(!empty($request->date_availability)){

            // $pincode=$request->pincode;
            // if(!empty($request->pincode) && session()->get('user_location')=='home'){
            //     if(!empty(Session::get('city'))){
            //     $city=ServiceCity::where('city',Session::get('city'))->first();
            //     $pujari=Pujari::whereJsonContains('pincode',''.$pincode)->whereJsonContains('city',''.$city->id)->get();

            //     if(count($pujari)>0){

                    $is_available='yes';
                    Cart::updateOrCreate(
                        [
                            'user_id'=>$user_id,
                            'product_id'=>$product->id,

                        ],[
                            'date'=>$request->date_availability,
                            'time'=>$request->time,
                            'city'=>session()->get('city'),
                            'language'=>session()->get('language'),
                            'location'=>session()->get('user_location')
                    ]);
            //     }
            //   }else{
            //     return redirect()->back()->withErrors(['msg' => 'Please Select City']);
            //   }
            // }

            if(session()->get('user_location')=='online'){

                $is_available='yes';
                Cart::updateOrCreate(
                    [
                        'user_id'=>$user_id,
                        'product_id'=>$product->id,

                    ],[
                        'date'=>$request->date_availability,
                        'time'=>$request->time,
                        'city'=>session()->get('city'),
                        'language'=>session()->get('language'),
                        'location'=>session()->get('user_location')
                ]);
            }

            if(session()->get('user_location')=='at_location'){

                $is_available='yes';
                Cart::updateOrCreate(
                    [
                        'user_id'=>$user_id,
                        'product_id'=>$product->id,

                    ],[
                        'date'=>$request->date_availability,
                        'time'=>$request->time,
                        'city'=>session()->get('city'),
                        'language'=>session()->get('language'),
                        'location'=>session()->get('user_location')
                ]);
            }
        }

        if($is_available=='yes'){
         return redirect()->route('checkout');
        }
        $product = Product::where('slug',$slug)->first();
        $review_list = Review::where('product_id',$product->id)->where('status',1)->get();
        $check_user=Auth::check();

        if($check_user)
        {
            $user_id=Auth::user()->id;
        }
        else
        {
            $check_session=Session::get('guest_id');
            if($check_session)
            {
                $user_id=$check_session;
            }
            else
            {
                $random_number=time().rand(1, 100);
                Session::put('guest_id','guest_'.$random_number);
                $user_id='guest_'.$random_number;
            }
        }
        $carts=Cart::where('user_id',$user_id)->whereHas('product', function ($query) {
            $query->where('product_type', '!=', 'one_day');
        })->get();
       
        if(count($carts) == 0){
            return redirect()->route('index')->with('error','Cart Is Empty!');
        }

        $packageid = $carts[0]->package_id;
        $package = Package::where('id' , $packageid)->first();
        $inclusions = Inclusion::where('package_id', $packageid)
        ->orderByRaw('CASE WHEN price < 1 THEN 1 ELSE 0 END')->get();
        $selectedInclusions = $carts
        ->pluck('inclusion')                // get the JSON string from each cart row
        ->map(fn($json) => json_decode($json, true) ?: [])  // decode to array
        ->flatten()                         // turn Collection of arrays into one flat collection
        ->unique()                          // (optional) remove duplicates
        ->toArray();
        return view('frontend.check-date-availability' ,compact('product', 'packages','is_available','inclusions','packageid','carts','selectedInclusions','package'));
     }else{
        return redirect()->back()->withErrors(['msg' => 'Please Select Package']);
     }
    }

    public function cart(){

        $check_user=Auth::check();

        if($check_user)
        {
            $user_id=Auth::user()->id;
        }
        else
        {
            $check_session=Session::get('guest_id');
            if($check_session)
            {
                $user_id=$check_session;
            }
            else
            {
                $random_number=time().rand(1, 100);
                Session::put('guest_id','guest_'.$random_number);
                $user_id='guest_'.$random_number;
            }
        }


        $carts=Cart::where('user_id',$user_id)->whereHas('product', function ($query) {
            $query->where('product_type', '!=', 'one_day');
        })->get();

        return view('frontend.cart',compact('carts'));
    }

    public function cart_remove($id)
        {
            try {
                $cartItem = Cart::findOrFail($id); // Find the cart item
                $cartItem->delete(); // Delete the cart item
                return response()->json(['success' => true, 'message' => 'Item removed successfully']);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Failed to remove item']);
            }
        }

    public function checkout(){

        $check_user=Auth::check();

        if($check_user)
        {
            $user_id=Auth::user()->id;
        }
        else
        {
            $check_session=Session::get('guest_id');
            if($check_session)
            {
                $user_id=$check_session;
            }
            else
            {
                $random_number=time().rand(1, 100);
                Session::put('guest_id','guest_'.$random_number);
                $user_id='guest_'.$random_number;
            }
        }
        $carts=Cart::where('user_id',$user_id)->whereHas('product', function ($query) {
            $query->where('product_type', '!=', 'one_day');
        })->get();
        if(count($carts) == 0){
            return redirect()->route('index')->with('error','Cart Is Empty!');
        }

        return view('frontend.checkout',compact('carts'));
    }

    public function one_day_puja()
    {
        $products = Product::where('status', 1)->where('product_type', 'one_day')->orderBy('date');
        if (!empty($request->category)) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $products = $products->where('category_id', $category->id);
            }
        }
        // $products = $products->where('date', '>=', Carbon::today());
        $products = $products->orderBy('date', 'desc')->get();
        $video_testimonials = Testimonial::where('type','video')->where('page','e_puja')->latest()->paginate(10);
        return view('frontend.one-day-puja', [ "page_title" => "One Day Puja", "products" => $products,"video_testimonials"=>$video_testimonials
        ]);
    }

    public function one_day_puja_details($slug)
    {
        $product = Product::where('product_type', 'one_day')->where('slug',$slug)->first();
        $package_list = Package::where('product_id',$product->id)->take(4)->get();
        $review_list = Review::where('product_id',$product->id)->get();
        $puja_benifit = PujaBenifit::where('product_id', $product->id)->get();
        $temple_detail = TempleDetails::where('product_id', $product->id)->first();
        return view('frontend.one-day-puja-details', compact('product', 'package_list', 'review_list', 'puja_benifit', 'temple_detail'));
    }

    public function one_day_package($id){
        $packages=Package::where('id',$id)->get();
        $product = Product::where('id',$packages[0]->product_id)->first();
        $temple_detail = TempleDetails::where('product_id', $product->id)->first();
        session()->put('city',$temple_detail->title);
        session()->put('user_location','At Location');
        $check_user=Auth::check();

        if($check_user){
            $user_id=Auth::user()->id;
        }else{
            $check_session=Session::get('guest_id');
            if($check_session){
                $user_id=$check_session;
            }else{
                $random_number=time().rand(1, 100);
                Session::put('guest_id','guest_'.$random_number);
                $user_id='guest_'.$random_number;
            }
        }

        Cart::where('user_id',$user_id)->delete();
        if(empty(Cart::where('user_id',$user_id)->where('product_id',$product->id)->where('package_id',$id)->first()->id)){

            Cart::updateOrCreate(
                [
                    'user_id'=>$user_id,
                    'product_id'=>$product->id,
                ],[

                    'package_id'=>$id,
                    'inclusion'=>'[]',
            ]);
        }
        return view('frontend.one-day-package',compact('product','packages'));
    }

    public function one_day_package_checkout()
    {
        $check_user=Auth::check();

        if($check_user)
        {
            $user_id=Auth::user()->id;
        }
        else
        {
            $check_session=Session::get('guest_id');
            if($check_session)
            {
                $user_id=$check_session;
            }
            else
            {
                $random_number=time().rand(1, 100);
                Session::put('guest_id','guest_'.$random_number);
                $user_id='guest_'.$random_number;
            }
        }
        $carts=Cart::where('user_id',$user_id)->get();
        if(count($carts) == 0){
            return redirect()->route('index')->with('error','Cart Is Empty!');
        }
        if($carts[0]->product->product_type != 'one_day'){
            return redirect()->route('index')->with('error','Cart Is Empty!');
        }
        return view('frontend.one-day-puja-checkout',compact('carts'));
    }

    public function all_puja(Request $request)
{
    // Base query: active, 'all' type, load category relation
    $base = Product::where('status',1)
                   ->where('product_type','all')
                   ->with('category')                // ← load category
                   ->withMin('packages','discount_price')
                   ->withMax('packages','discount_price');

    // apply category filter from URL if not “all”
    $selected = $request->category ?? 'all';
    if($selected!=='all') {
      $cat = Category::where('slug',$selected)->first();
      if($cat) $base->where('category_id',$cat->id);
    }
    $products = $base->get();

    // for accordion: all products grouped by category
    $allProducts = Product::where('status',1)
                          ->where('product_type','all')
                          ->with('category')              // ← load category
                          ->withMin('packages','discount_price')
                          ->withMax('packages','discount_price')
                          ->get()
                          ->groupBy(fn($p)=>$p->category->slug);

    $categories = Category::where('status',1)->get();
    $video_testimonials = Testimonial::where('type','video')
                                     ->where('page','pooja')
                                     ->latest()
                                     ->paginate(10);

    return view('frontend.all_puja', compact(
      'products','video_testimonials',
      'categories','selected','allProducts'
    ));
}

    

    

    public function listing(Request $request){

        $products = Product::where('status',1)->where('product_type','all');
        if(!empty($request->city)){
            session()->put('city', $request->city);
            Session::forget('user_location');
            $city=ServiceCity::where('city',$request->city)->first();
        }
        if(!empty($request->language)){
            session()->put('language', $request->language);
            $language=Language::where('language',$request->language)->first();
            $products=$products->whereJsonContains('language',''.$language->id);

        }
        if(!empty($request->category)){
            $category=Category::where('slug',$request->category)->first();
            $products=$products->where('category_id',$category->id);
        }

        if($request->search){
            $products=$products->where('name','like','%'.$request->search.'%');
        }
        $products=$products->get();
        Session::forget('user_location');
        return view('frontend.listing',compact('products'));
    }

    public function product_details(Request $request, $slug)
    {
        $product = Product::where('slug',$slug)->first();
        $review_list = Review::where('product_id',$product->id)->where('status',1)->get();
        $packages=Package::where('product_id',$product->id)->get();
        if(count($packages) > 0){
            $minPrice = $packages->min('discount_price');
            $maxPrice = $packages->max('discount_price');
        }else{
            $minPrice=0;
            $maxPrice=0;
        }
        $city=ServiceCity::where('city',Session::get('city'))->first();
        if(empty($city) ){
            if((Session::get('city')!='E-puja(Online)') && ($product->product_type != 'temple')){
                Session::forget('city');
             }
        }
        if($product->product_type == 'temple'){
            Session::forget('language');
        }

        $check_user=Auth::check();

        if($check_user)
        {
            $user_id=Auth::user()->id;
        }
        else
        {
            $check_session=Session::get('guest_id');
            if($check_session)
            {
                $user_id=$check_session;
            }
            else
            {
                $random_number=time().rand(1, 100);
                Session::put('guest_id','guest_'.$random_number);
                $user_id='guest_'.$random_number;
            }
        }

        $carts=Cart::where('user_id',$user_id)->delete();

        $check_user=Auth::check();


        if($check_user)
        {
            $user_id=Auth::user()->id;
        }
        else
        {
            $check_session=Session::get('guest_id');
            if($check_session)
            {
                $user_id=$check_session;
            }
            else
            {
                $random_number=time().rand(1, 100);
                Session::put('guest_id','guest_'.$random_number);
                $user_id='guest_'.$random_number;
            }
        }
        $cartsitems=Cart::where('user_id',$user_id)->get();
        $request->session()->put('url.intended', url()->full());

        return view('frontend.product-details',compact('product', 'packages','minPrice','maxPrice', 'review_list','cartsitems'));
    }

    public function reviewSubmit(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:1000',
        ]);
        $review = new Review();
        $review->product_id = $request->product_id;
        $review->user_id = Auth::user()->id;
        $review->rating = $request->rating;
        $review->review = $request->review;
        $review->save();

        return back()->with('success', 'Review Submitted Successfully!');
    }

    // public function product_package($slug){

    //     $product = Product::where('slug',$slug)->first();
    //     $packages=Package::where('product_id',$product->id)->get();

    //     $check_user=Auth::check();


    //     if($check_user)
    //     {
    //         $user_id=Auth::user()->id;
    //     }
    //     else
    //     {
    //         $check_session=Session::get('guest_id');
    //         if($check_session)
    //         {
    //             $user_id=$check_session;
    //         }
    //         else
    //         {
    //             $random_number=time().rand(1, 100);
    //             Session::put('guest_id','guest_'.$random_number);
    //             $user_id='guest_'.$random_number;
    //         }
    //     }
    //     $carts=Cart::where('user_id',$user_id)->get();
       
    //     return view('frontend.product-package',compact('product','packages','carts'));
    // }

    public function set_location(Request $request){
        $product = Product::find($request->id);
        Session::put('user_location', $request->location);
        if($request->location=='home'){
            if($product->product_type == 'all'){
                Session::forget('city');
            }
        }

        if($request->location=='online'){
            if($product->product_type == 'all'){
                 session()->put('city','E-puja(Online)');
            }
        }
        return 1;

    }

    public function set_pooja_language(Request $request){

        Session::put('pooja_language', $request->pooja_language);
        return 1;

    }

    public function set_city(Request $request){

        if($request->city!='E-puja(Online)'){
          Session::put('city', $request->city);
          Session::put('user_location', 'home');
        }
        if($request->city=='E-puja(Online)'){
            Session::put('city', $request->city);
            Session::put('user_location', 'online');
        }
        return 1;

    }

    public function set_language(Request $request){

        Session::put('language', $request->pooja_language);
        return 1;

    }



    public function get_razorpay_order_id(Request $request)
    {

        $check_user = Auth::check();
        $user_id = $check_user ? Auth::user()->id : Session::get('guest_id');

        $total_price = 0;
        $total_advance = 0;
        $total_inclusion_advance=0;
        $carts = Cart::where('user_id', $user_id)->get();

        foreach ($carts as $cart) {
            $total_inclusion = 0;
            if ($cart->inclusion && count(json_decode($cart->inclusion)) > 0) {
                foreach (json_decode($cart->inclusion) as $inclusion) {
                    $inclusion_data = Inclusion::find($inclusion);
                    if ($inclusion_data) {
                        $total_inclusion += $inclusion_data->price;
                        $total_inclusion_advance=$total_inclusion_advance+$inclusion_data->advance;
                    }
                }
            }
            $package_price = $cart->package->discount_price ?? $cart->package->price;
            $total = $package_price + $total_inclusion;
            $total_price += $total;
            $total_advance += ($cart->package->advance+$total_inclusion_advance);

            if($request->is_prasahd=='yes'){
                $prashad_price = $cart->product->prashad_price;
            }
        }
        $total_amount = $request->deposite_radio == 'pay_advance' ? $total_advance : $total_price;
        if(!empty($request->dakshina)){
            $total_amount=$total_amount+$request->dakshina;
        }
        if($request->is_prasahd=='yes'){
            $total_amount += $prashad_price;
        }

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $data = $api->order->create([
            'receipt' => ''.rand(111111, 999999),
            'amount' => (int) $total_amount * 100,
            'currency' => 'INR',
            'notes' => [
                'key1' => 'value3',
                'key2' => 'value2'
            ]
        ]);


        return ['r_order_id' => $data['id']];
    }


    public function attemptLogin(Request $request)
    {
        // dd($request->all());
        if (filter_var($request->input_name, FILTER_VALIDATE_EMAIL)) {

            $customer = User::where('email', $request->input_name)->first();
            if (!empty($customer)) {
                if ($customer && Hash::check($request->password, $customer->password)) {
                        Auth::login($customer, false);
                        $check_session = Session::get('guest_id');
                        if ($check_session) {
                            $user_id = $check_session;
                            $carts = Cart::where('user_id', $user_id)->get();

                            foreach ($carts as $cart) {
                                // Remove existing cart of the same product for the customer
                                Cart::where('user_id', $customer->id)
                                    ->where('product_id', $cart->product_id)
                                    ->delete();

                                // Reassign the cart to the new customer
                                $cart->user_id = $customer->id;
                                $cart->save();
                            }

                        }
                        session()->forget('guest_id');
                        return redirect()->route('dashboard');
                    }else{
                            return back()->withErrors([
                                'password' => 'The provided password do not match our records.',
                            ]);
                        }
            }else{
                return back()->withErrors([
                    'email' => 'The provided email do not match our records.',
                ]);
            }
        } else {


            $customer = User::where('phone', $request->input_name)->first();
            if (!empty($customer)) {
                Auth::login($customer, false);
                $check_session = Session::get('guest_id');
                if ($check_session) {
                    $user_id = $check_session;
                    $carts = Cart::where('user_id', $user_id)->get();

                    foreach ($carts as $cart) {
                        // Remove existing cart of the same product for the customer
                        Cart::where('user_id', $customer->id)
                            ->where('product_id', $cart->product_id)
                            ->delete();
                    
                        // Reassign the cart to the new customer
                        $cart->user_id = $customer->id;
                        $cart->save();
                    }
                    

                }
                session()->forget('guest_id');
                return redirect()->intended(route('dashboard'));
            }
        }
    }

    public function attemptLogout()
    {
        Auth::logout();
        return redirect()->route('index');
    }

    public function send_otp(Request $request)
    {

            $mobileregex = "/^[6-9][0-9]{9}$/";
            if ($request->phone != '' && preg_match($mobileregex, $request->phone) === 1) {
                $user = User::where('phone', $request->phone)->first();
                if (!empty($user->id)) {
                    
                    $mob_otp = rand(1000, 9999);
                    Session::forget('mob_otp');
                    Session::put('mob_otp', [$mob_otp]);
                    $user->otp = $mob_otp;

                    $user->update(['otp'=> $mob_otp]);
                    if ($request->form_name == 'sms_form') {
                        login_by_sms($request->phone, $mob_otp);
                    }
                    return response()->json(['status' => true, 'otp' => $mob_otp]);
                }else {
                    $random_number=time().rand(1, 100);
                    $user_id='guest_'.$random_number;
                    $user=new User;
                    $user->name=$user_id;
                    $user->phone=$request->phone;
                    $user->password=Hash::make($request->phone);
                    $user->save();

                    $mob_otp = rand(1000, 9999);
                    Session::forget('mob_otp');
                    Session::put('mob_otp', [$mob_otp]);
                    $user->otp = $mob_otp;
                    $user->save();
                    if ($request->form_name == 'sms_form') {
                        login_by_sms($request->phone, $mob_otp);
                    }
                    return response()->json(['status' => true, 'otp' => $mob_otp]);
                }
            } else {
                return response()->json(['status' => false]);
            }

    }

    public function check_otp(Request $request)
    {

        $otp = Session::get('mob_otp');
        if ($otp[0] == $request->otp) {
            return response()->json(['status' => true]);
        } else {
            return response()->json(['status' => false]);
        }
    }

    public function send_regsiter_otp(Request $request)
    {
            $mobileregex = "/^[6-9][0-9]{9}$/";
            if ($request->phone != '' && preg_match($mobileregex, $request->phone) === 1) {
                    $mob_otp = rand(1000, 9999);
                    Session::forget('mob_otp');
                    Session::put('mob_otp', [$mob_otp]);

                  login_by_sms($request->phone, $mob_otp);

                  return response()->json(['status' => true, 'otp' => $mob_otp]);
                }else{
                    return response()->json(['status' => false]);
                }
    }


    public function user_dashboard(Request $request){

        return view('user_dashboard.dashboard');

    }

    public function getPincode(Request $request)
    {
        $city=ServiceCity::where('city', $request->city_id)->first();
        return $pincodes = Pincode::where('city', $city->id)->where('status', 'active')->get();
        return response()->json($pincodes);
    }

    public function searchPlace(Request $request)
    {
        $query = $request->input('query');
        $apiKey = env('GOOGLE_PLACES_API_KEY');
        $client = new Client();

        $response = $client->get('https://maps.googleapis.com/maps/api/place/textsearch/json', [
            'query' => [
                'query' => $query,
                'key' => $apiKey,
            ],
        ]);

        $places = json_decode($response->getBody(), true);


        $results = [];
        if (isset($places['results'])) {
            foreach ($places['results'] as $place) {
                $results[] = [
                    'id' => $place['place_id'],
                    'text' => $place['formatted_address']
                ];
            }
        }

        return response()->json(['results' => $results]);
    }

}


