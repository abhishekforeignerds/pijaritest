<?php

namespace App\Http\Controllers\Api;

use App\Models\Favourite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FavouriteApiController extends Controller
{
    public function addFavourite(Request $request){
        $add_fav = new Favourite;
        $add_fav->user_id = auth()->user()->id;
        $add_fav->product_id = $request->product_id;
        $add_fav->variant_id = $request->variant_id;
        $add_fav->save();

        return response()->json([
            'success' => true,
            'message' => 'Product Added to Favourite',
            'data'    => $add_fav
        ], 200);
    }

    public function getFavourite(){
        $userId = auth()->id();
        $get_fav = Favourite::where('user_id', $userId)->paginate(8);

        return response()->json([
            'success' => true,
            'message' => 'Favourite List',
            'data'    => $get_fav
        ], 200);
    }

    public function delete($id){
        Favourite::where('id', $id)->first()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product Removed from Favourite'
        ], 200);
    }
}
