<?php

namespace App\Http\Controllers\Api;

use App\Models\Banner;
use App\Models\Slider;
use App\Models\Pincode;
use App\Models\Product;
use App\Models\AppSetup;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\CategoryResource;

class HomeApiController extends Controller
{
    public function index(){
        try {
            $slider = Slider::where('status','1')->get();
            $category = Category::where('status','1')->where('featured','1')->orderBy('priority','asc')->get();
            $app_setup=AppSetup::all();
            return response()->json([
                'success'  => true,
                'slider'   => $slider,
                'category' => CategoryResource::collection($category),
                'app_setup' => $app_setup
            ]);
        }
        catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong !',
                'error'   => $th->getMessage()
            ], 401);
        }
    }

    public function search(Request $request){
        $search = $request->key;
        $searchProducts = Product::where('status',1)->where('name','like','%'.$search.'%')->paginate(20);

        return response()->json([
            'success' => true,
            'data'    => ProductResource::collection($searchProducts)
        ], 200);
    }

    public function getDeliveryPincode(Request $request){

        $pincode = Pincode::where('status','active')->get();

        return response()->json([
            'success' => true,
            'data'    => $pincode
        ], 200);
    }

    public function area_pincode_list(Request $request)
    {
        $pincodes = Pincode::where('status', 'active')->where('area', 'like', $request->key . '%')->groupBy('area')->get();

        $data = array();

        foreach ($pincodes as $pincode) {
            $data[] = array("id" => $pincode->id, "area" => $pincode->area,"pincode" => $pincode->pincode,'city'=>$pincode->city,'state'=>$pincode->state);
        }

        return response()->json([
            'success' => true,
            'data'    => $data
        ], 200);
    }
}
