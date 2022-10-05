<?php

namespace App\Http\Controllers;
use App\Models\Brand;
use App\Models\User;
use App\Models\Role;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AController;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\HelpersController as Helpers;


class BrandsController extends AController
{
    public function index()
    {       
        $this->access = Helpers::checkaccess('brands', 'view');
        if(!$this->access) {
            Session::flash('message', "you don't have permission to access");
            return redirect('/dashboard');  
        }
        
        $datas = Brand::get();
        return view('brands.index', array(
            'datas' => $datas,
            'user' => User::where('id_role', '!=', 99)->get(),
            'brands' => Brand::where('id','!=', 0)->orderBy('brand_name', 'ASC')->get(),
        )); 
    }

    public function apiGetData(Request $request)
    {
        if($request->brand_name != null || $request->active != null) 
        {
            $whereraw = '';
            if($request->brand_name != null) $whereraw .= " and brand_name like '%$request->brand_name%'";
            if($request->active != null) $whereraw .= " and active = $request->active";

    		$whereraw = preg_replace('/ and/', '', $whereraw, 1); // replace first and
            $brands = Brand::whereRaw($whereraw)->get();    
        } 
        $brands = Brand::where('id','!=', 0)->get();


        if(Auth::user()->id_role == 1) { // untuk admin
            $brands = $brands->where('flag_delete', 0);
        } 
        

        $datas = [];
        foreach($brands as $key => $value)
        {
            $datas[$key] = [
                '',                     // 0
                $value->brand_name,  // 1
                $value->id,             // 2
                $value->active,         // 3
                $value->flag_delete,    // 4
                $value->created_at,     // 5
                $value->updated_at,     // 6
                $value->created_by,     // 7
                $value->updated_by,     // 8


            ];
        }
        return response()->json(['data' => $datas, 'status' => '200'], 200);
    }

    public function apiGetDataById($id)
    {
        $details = Brand::where('id', $id)->orderBy('id', 'ASC')->first();
            
        $vDetailData = [];
        $i = 1; 
        
        foreach ($details as $key => $value) 
        {
            $vDetailData[$key] = [
                $i++,                    // 0
                $details->brand_name, // 1
                $details->id,            // 2
                $details->active,        // 3
                $details->flag_delete,   // 4
            ];
        }
    
        return response()->json(['data' => $details, 'status' => '200'], 200);

    }

    public function apiInsertData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'brand_name' => 'required|min:4|unique:brands',
        ], [
            'brand_name.unique' => 'Nama Brand Tidak Boleh Sama',
            'brand_name.required' => 'Nama Brand Harus Di Isi',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=> $validator->errors()->all()]);
        }
        
        $category = new Brand();
        $category->brand_name = $request->brand_name;
        $category->created_at = date('Y-m-d H:i:s');
        $category->updated_at = date('Y-m-d H:i:s');
        $category->active = $request->active;
        $category->created_by = Auth::user()->id;
        $category->save();


        return response()->json(['data' => ['success'], 'status' => '200'], 200);
    }

    public function apiUpdateDataById($id, Request $request)
    {
        $updateBrand = Brand::where('brand_name', $request->brand_name)->first();
        if (isset($updateBrand->id) && $updateBrand->id != $id) 
        {
            return response()->json(['errors' => [false, 'Nama Brand sudah ada'], 'status' => '401'], 200);
        }
        
        $updateBrand = Brand::where('id', $id)->first();
        $updateBrand->brand_name = $request->brand_name;
        $updateBrand->active = $request->active;
        $updateBrand->updated_at = date('Y-m-d H:i:s');
        $updateBrand->updated_by = Auth::user()->id;
        $updateBrand->save();
        return response()->json(['data' => ['success'], 'status' => '200'], 200);
    }
    

    public function apiDeleteDataById($id, Request $request)
    {
        $deleteBrand = Brand::where('id', $id)->first();
        
        $deleteBrand->flag_delete = 1;
        if(isset($request->undeleted)) $deleteBrand->flag_delete = 0;
        $deleteBrand->save();


        return response()->json(['data' => ['success'], 'status' => '200'], 200);

    }
    

}
