<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use QrCode;
use Haruncpi\LaravelIdGenerator\IdGenerator;

use App\Http\Controllers\HelpersController as Helpers;

class QrcodeController extends Controller
{
    public function generateqrcode()
    {
        $config = ['table' => 'products', 'field' => 'barcode', 'length' => 6, 'prefix' => date('YmdHis') ]; //

        $barcode = IdGenerator::generate($config);   

    	$getsvgqrcode = Helpers::generateqrcode($barcode);

        // dd($getsvgqrcode);

    	echo json_decode($getsvgqrcode)->data[0];
    }

    // $csrf = csrf_field();
    // $validator = Validator::make($params = $request->all(), [
    // 'image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048'
    // ]);


    // if ($validator->fails()) 
    // {
    //     return response()->json(['errors'=>$validator->errors()]);
    // }

    // if ($request->file() != null) 
    // {
    //     $rf = Helpers::uploadImage($request, "nameprod1");
    // }

}
