<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AController;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\HelpersController as Helpers;


class CategoryController extends AController
{
    public function index()
    {       
        $this->access = Helpers::checkaccess('categories', 'view');
        if(!$this->access) {
            Session::flash('message', "you don't have permission to access");
            return redirect('/dashboard');  
        }
        
        $datas = Category::get();
        return view('categories.index', array(
            'datas' => $datas,
            'categories' => Category::where('id','!=', 0)->orderBy('category_name', 'ASC')->get(),
        )); 
    }

    public function apiGetData(Request $request)
    {
        if($request->category_name != null || $request->active != null) 
        {
            $whereraw = '';
            if($request->category_name != null) $whereraw .= " and category_name like '%$request->category_name%'";
            if($request->active != null) $whereraw .= " and active = $request->active";

    		$whereraw = preg_replace('/ and/', '', $whereraw, 1); // replace first and
            $categories = Category::whereRaw($whereraw)->get();    
        } else {
            $categories = Category::where('id','!=', 0)->get();
        }

        if(Auth::user()->id_role == 1) { // untuk admin
            $categories= $categories->where('flag_delete', 0);
        } 
        
        $datas = [];
        foreach($categories as $key => $value)
        {
            $datas[$key] = [
                '',                     // 0
                $value->category_name,  // 1
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
        $details = Category::where('id', $id)->orderBy('id', 'ASC')->first();
            
        $vDetailData = [];
        $i = 1; 
        
        foreach ($details as $key => $value) 
        {
            $vDetailData[$key] = [
                $i++,                    // 0
                $details->category_name, // 1
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
            'category_name' => 'required|min:4|unique:categories',
        ], [
            'category_name.unique' => 'Nama Kategori Tidak Boleh Sama',
            'category_name.required' => 'Nama Kategori Harus Di Isi',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=> $validator->errors()->all()]);
        }
        
        $category = new Category();
        $category->category_name = $request->category_name;
        $category->created_at = date('Y-m-d H:i:s');
        $category->updated_at = date('Y-m-d H:i:s');
        $category->active = $request->active;
        $category->created_by = Auth::user()->id;
        $category->save();


        return response()->json(['data' => ['success'], 'status' => '200'], 200);
    }

    public function apiUpdateDataById($id, Request $request)
    {
        $updateCategory = Category::where('category_name', $request->category_name)->first();
        if (isset($updateCategory->id) && $updateCategory->id != $id) 
        {
            return response()->json(['errors' => [false, 'Nama Kategori sudah ada'], 'status' => '401'], 200);
        }
        
        $updateCategory = Category::where('id', $id)->first();
        $updateCategory->category_name = $request->category_name;
        $updateCategory->active = $request->active;
        $updateCategory->updated_at = date('Y-m-d H:i:s');
        $updateCategory->updated_by = Auth::user()->id;
        $updateCategory->save();
        return response()->json(['data' => ['success'], 'status' => '200'], 200);
    }
    

    public function apiDeleteDataById($id, Request $request)
    {
        $deleteCategory = Category::where('id', $id)->first();
        
        $deleteCategory->flag_delete = 1;
        if(isset($request->undeleted)) $deleteCategory->flag_delete = 0;
        $deleteCategory->save();


        return response()->json(['data' => ['success'], 'status' => '200'], 200);

    }

}
