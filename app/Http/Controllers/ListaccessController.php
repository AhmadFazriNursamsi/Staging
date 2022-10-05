<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Division;
use App\Models\Role;
use App\Models\Useraccess;
use App\Models\Listaccess;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\HelpersController as Helpers;

class ListaccessController extends AController
{
    public function index(){
        $this->access = Helpers::checkaccess('listaccess', 'view');
        if(!$this->access) {
            Session::flash('message', "you don't have permission to access");
            return redirect('/dashboard');  
        }

        $datas = Listaccess::get();
        return view('listaccess.index', array(
            'datas'  => $datas,
        ));
    }

    public function apiInsertData(Request $request){
        $this->access = Helpers::checkaccess('listaccess', 'add');
        if(!$this->access) return response()->json(['data' => ['false'], 'status' => '401'], 200);

        $validator = Validator::make($request->all(), [
           'name_access' => 'required',
           'name_url' => 'required|unique:list_access'
       ]);
        
       if ($validator->fails()) {
            return response()->json(['data' => [$validator->messages()->first()], 'status' => '401'], 200);
       }

        $datas = new Listaccess;
        $datas->name_access = $request->name_access;
        $datas->name_url = $request->name_url;
        if($datas->save())
            return response()->json(['data' => ['success'], 'status' => '200'], 200);
        else 
            return response()->json(['data' => ['false'], 'status' => '200'], 200);
    }


    public function apiUpdateData(Request $request){
        $this->access = Helpers::checkaccess('listaccess', 'edit');
        if(!$this->access) return response()->json(['data' => ['false'], 'status' => '401'], 200);

        $ceknama = Listaccess::where('name_access', $request->name_access)->first();
        if (isset($ceknama->id_access) && $ceknama->id_access != $request->id_access) 
        {
        return response()->json(['data' => [false, 'nama sudah ada'], 'status' => '401'], 200);
        }

        $datas = Listaccess::where('id_access', $request->id_access)->first();
        $datas->name_access = $request->name_access;
        $vartampung = $datas->name_url;
        $datas->name_url = $request->name_url;
        
        if($datas->save()){

            $cek = Useraccess::where('id_access', $request->id_access)->delete();
        
            
            if (isset($cek))
            {
                    $users_access = new Useraccess;
                    $users_access->id_users = $request->id_access;
                    $users_access->name_access = $vartampung; 
                    $users_access->save();
                }   
                return response()->json(['data' => ['success'], 'status' => '200'], 200);
            }
        else 
        return response()->json(['data' => ['false'], 'status' => '200'], 200);
    }

    public function apiGetDataListAccess(Request $request){
        $this->access = Helpers::checkaccess('listaccess', 'view');
        if(!$this->access) return response()->json(['data' => [], 'status' => '401'], 200);
        $whereraw = '';

        $listaccess = Listaccess::get();
        if($request->name_access != null || $request->name_url != null || $request->active != null){
            if($request->name_access != null) $whereraw .= " and name_access like '%$request->name_access%'";
            if($request->name_url != null) $whereraw .= " and name_url like '%$request->name_url%'";
            if($request->active != null) $whereraw .= " and flag_delete = $request->active";

            $whereraw = preg_replace('/ and/', '', $whereraw, 1); // replace first and
            $listaccess = Listaccess::whereRaw($whereraw)->get();
        } else {
            $listaccess = Listaccess::get();
        }

        $datas = [];
        foreach($listaccess as $key => $access){
            $datas[$key] = [
                '', $access->name_access, $access->name_url, $access->flag_delete, $access->id_access
            ];
        }

        return response()->json(['data' => $datas, 'status' => '200'], 200);
    }

    public function apiGetDataListAccessById($id, Request $request){
        $this->access = Helpers::checkaccess('listaccess', 'view');
        if(!$this->access) return response()->json(['data' => $datas, 'status' => '401'], 200);

        $datas = Listaccess::where('id_access', $id)->get();

        return response()->json(['data' => $datas, 'status' => '200'], 200);
    }

    public function apiDeleteListAccessById($id, Request $request){
        $this->access = Helpers::checkaccess('listaccess', 'delete');
        if(!$this->access) return response()->json(['data' => ['false'], 'status' => '401'], 200);

        $datas = Listaccess::where('id_access', $id)->first();
        
        $datas->flag_delete = 1;
        if(isset($request->undeleted)) $datas->flag_delete = 0;  
        $datas->save();

        echo 'success';
    }
}
