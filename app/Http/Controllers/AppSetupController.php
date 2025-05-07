<?php

namespace App\Http\Controllers;

use App\Models\AppSetup;
use Illuminate\Http\Request;

class AppSetupController extends Controller
{
    public function index(){
        return view('backend.app_setup.index');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        foreach ($input['type'] as $types){
            if(isset($input[$types])){
                if($types == "logo"){
                    $logoImage = time().rand(99, 999).'.'.$input[$types]->extension();
                    $input[$types]->move(public_path('backend/images/app_setup'), $logoImage);
                    $input[$types] = $logoImage;
                }

                if($types == "favicon"){
                    $faviconImage = time().rand(99, 999).'.'.$input[$types]->extension();
                    $input[$types]->move(public_path('backend/images/app_setup'), $faviconImage);
                    $input[$types] = $faviconImage;
                }

                AppSetup::updateOrCreate(
                    ["name" => $types],
                    [
                        "name" => $types,
                        "value" => $input[$types]
                    ],
                );
            }else{
                if($types != "logo" && $types != "favicon" ){
                    AppSetup::updateOrCreate(
                        ["name" => $types],
                        [
                            "name" => $types,
                            "value" => $input[$types]
                        ],
                    );
                }
            }
        }
        return redirect()->back()->with('success',  'App Setup updated successfully');
    }
}
