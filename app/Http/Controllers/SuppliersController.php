<?php

namespace App\Http\Controllers;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Role;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AController;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\HelpersController as Helpers;


class SuppliersController extends AController
{
    public function index()
    {       
        $this->access = Helpers::checkaccess('suppliers', 'view');
        if(!$this->access) {
            Session::flash('message', "you don't have permission to access");
            return redirect('/dashboard');  
        }
        
        $datas = Supplier::get();
        return view('suppliers.index', array(
            'datas' => $datas,
            'suppliers' => Supplier::where('id','!=', 0)->orderBy('supplier_name', 'ASC')->get(),
        )); 
    }

    public function apiGetData(Request $request)
    {
        if($request->supplier_name != null || $request->active != null) 
        {
            $whereraw = '';
            if($request->supplier_name != null) $whereraw .= " and supplier_name like '%$request->supplier_name%'";
            if($request->active != null) $whereraw .= " and active = $request->active";

    	    $whereraw = preg_replace('/ and/', '', $whereraw, 1); // replace first and
            $suppliers = Supplier::whereRaw($whereraw)->get();    
        } 
        
        $suppliers = Supplier::where('id','!=', 0)->get();
        if(Auth::user()->id_role == 1) { // untuk admin
            $suppliers= $suppliers->where('flag_delete', 0);
        } 
        
        $datas = [];
        foreach($suppliers as $key => $value)
        {
            $datas[$key] = [
                '',                     // 0
                $value->supplier_name,  // 1
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
        $details = Supplier::where('id', $id)->orderBy('id', 'ASC')->first();
            
        $vDetailData = [];
        $i = 1; 
        
        foreach ($details as $key => $value) 
        {
            $vDetailData[$key] = [
                $i++,                    // 0
                $details->supplier_name, // 1
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
            'supplier_name' => 'required|min:4|unique:suppliers',
        ], [
            'supplier_name.unique' => 'Nama Supplier Tidak Boleh Sama',
            'supplier_name.required' => 'Nama Supplier Harus Di Isi',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=> $validator->errors()->all()]);
        }
        
        $category = new Supplier();
        $category->supplier_name = $request->supplier_name;
        $category->created_at = date('Y-m-d H:i:s');
        $category->updated_at = date('Y-m-d H:i:s');
        $category->active = $request->active;
        $category->created_by = Auth::user()->id;
        $category->save();


        return response()->json(['data' => ['success'], 'status' => '200'], 200);
    }

    public function apiUpdateDataById($id, Request $request)
    {
        $updateSupplier = Supplier::where('supplier_name', $request->supplier_name)->first();
        if (isset($updateSupplier->id) && $updateSupplier->id != $id) 
        {
            return response()->json(['data' => [false, 'Nama Supplier sudah ada'], 'status' => '401'], 200);
        }
        
        $updateSupplier = Supplier::where('id', $id)->first();
        $updateSupplier->supplier_name = $request->supplier_name;
        $updateSupplier->active = $request->active;
        $updateSupplier->updated_at = date('Y-m-d H:i:s');
        $updateSupplier->updated_by = Auth::user()->id;
        $updateSupplier->save();
        return response()->json(['data' => ['success'], 'status' => '200'], 200);
    }
    

    public function apiDeleteDataById($id, Request $request)
    {
        $deleteSupplier = Supplier::where('id', $id)->first();
        
        $deleteSupplier->flag_delete = 1;
        if(isset($request->undeleted)) $deleteSupplier->flag_delete = 0;
        $deleteSupplier->save();


        return response()->json(['data' => ['success'], 'status' => '200'], 200);

    }
    

}
