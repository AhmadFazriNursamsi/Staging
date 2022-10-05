<?php

namespace App\Http\Controllers;
use App\Models\Satuan;
use App\Models\User;
use App\Models\Role;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AController;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\HelpersController as Helpers;


class SatuansController extends AController
{
    public function index()
    {       
        $this->access = Helpers::checkaccess('satuans', 'view');
        if(!$this->access) {
            Session::flash('message', "you don't have permission to access");
            return redirect('/dashboard');  
        }
        
        $datas = Satuan::get();
        return view('satuans.index', array(
            'datas' => $datas,
            'satuans' => Satuan::where('id','!=', 1)->orderBy('satuan_name', 'ASC')->get(),
        )); 
    }

    public function apiGetData(Request $request)
    {
        if($request->satuan_name != null || $request->active != null) 
        {
            $whereraw = '';
            if($request->satuan_name != null) $whereraw .= " and satuan_name like '%$request->satuan_name%'";
            if($request->active != null) $whereraw .= " and active = $request->active";

    		$whereraw = preg_replace('/ and/', '', $whereraw, 1); // replace first and
            $satuans = Satuan::whereRaw($whereraw)->get();    
        } 
        
        $satuans = Satuan::where('id','!=', 0)->get();
        if(Auth::user()->id_role == 1) { // untuk admin
            $satuans= $satuans->where('flag_delete', 0);
        } 
        
        $datas = [];
        foreach($satuans as $key => $value)
        {
            $datas[$key] = [
                '',                     // 0
                $value->satuan_name,  // 1
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
        $details = Satuan::where('id', $id)->orderBy('id', 'ASC')->first();
            
        $vDetailData = [];
        $i = 1; 
        
        foreach ($details as $key => $value) 
        {
            $vDetailData[$key] = [
                $i++,                    // 0
                $details->satuan_name, // 1
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
            'satuan_name' => 'required|min:4|unique:satuans',
        ], [
            'satuan_name.unique' => 'Nama Satuan Tidak Boleh Sama',
            'satuan_name.required' => 'Nama Satuan Harus Di Isi',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=> $validator->errors()->all()]);
        }
        
        $category = new Satuan();
        $category->satuan_name = $request->satuan_name;
        $category->created_at = date('Y-m-d H:i:s');
        $category->updated_at = date('Y-m-d H:i:s');
        $category->active = $request->active;
        $category->created_by = Auth::user()->id;
        $category->save();


        return response()->json(['data' => ['success'], 'status' => '200'], 200);
    }

    public function apiUpdateDataById($id, Request $request)
    {
        $updateSatuan = Satuan::where('satuan_name', $request->satuan_name)->first();
        if (isset($updateSatuan->id) && $updateSatuan->id != $id) 
        {
            return response()->json(['errors' => [false, 'Nama Satuan sudah ada'], 'status' => '401'], 200);
        }
        
        $updateSatuan = Satuan::where('id', $id)->first();
        $updateSatuan->satuan_name = $request->satuan_name;
        $updateSatuan->active = $request->active;
        $updateSatuan->updated_at = date('Y-m-d H:i:s'); //
        $updateSatuan->updated_by = Auth::user()->id;
        $updateSatuan->save();
        return response()->json(['data' => ['success'], 'status' => '200'], 200);
    }

    public function apiDeleteDataById($id, Request $request)
    {
        $deleteSatuan = Satuan::where('id', $id)->first();
        
        $deleteSatuan->flag_delete = 1;
        if(isset($request->undeleted)) $deleteSatuan->flag_delete = 0;
        $deleteSatuan->save();


        return response()->json(['data' => ['success'], 'status' => '200'], 200);

    }
    

}
