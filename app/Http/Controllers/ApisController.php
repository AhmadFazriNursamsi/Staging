<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Division;
use App\Models\Role;
use App\Models\Useraccess;
use App\Models\Listaccess;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\HelpersController as Helpers;
use App\Models\Gudang;
use App\Models\List_user_gudang;
use Auth;
use DB;

class ApisController extends AController
{
    public function apigetdatauser(Request $request){
    	$this->access = Helpers::checkaccess('users', 'view');
        if(!$this->access) return response()->json(['data' => $datas, 'status' => '401'], 200);

        if(Auth::user()->id_role == 1){
            $idd = Auth::user()->id;
            $listGudang  = List_user_gudang::with('users')->where('id_user', $idd);
            $tampung = [];
            $listGudang = $listGudang->get();
            foreach($listGudang as $key => $lis){
                $tampung[$key] = [
                    $lis->id_gudang
                ];
            }

            
                $db = DB::table('users')
                ->select('nama','name','username', 'email','mobile','users.id_division','division.division_name','users.id_role','role.role_name','id_user','users.active', 'users.flag_delete', 'gudang.id')
                ->join('list_user_gudang', 'list_user_gudang.id_user', '=', 'users.id')
                ->join('gudang', 'gudang.id', '=', 'list_user_gudang.id_gudang')
                ->join('division', 'division.id_division', '=', 'users.id_division')
                ->join('role', 'role.id_role', '=', 'users.id_role')
                ->where('users.id_role', '!=', 1)
                ->where('list_user_gudang.id_gudang', $tampung);
                // ->get();

                if($request->name != null ||$request->gudang != null || $request->email != null || $request->division != null || $request->username != null || $request->role != null || $request->mobile != null || $request->active != null) {
                    $whereraw = '';
        
                    if($request->name != null) $whereraw .= " and users.name like '%$request->name%'";
                    if($request->username != null) $whereraw .= " and users.username like '%$request->username%'";
                    if($request->email != null) $whereraw .= " and users.email like '%$request->email%'";
                    if($request->mobile != null) $whereraw .= " and users.mobile like '%$request->mobile%'";
                    if($request->gudang != null) $whereraw .= " and gudang.id = $request->gudang";
                    if($request->role != null) $whereraw .= " and users.id_role = $request->role";

                    if($request->active != null) $whereraw .= " and users.active = $request->active";
                    if($request->division != null) $whereraw .= " and division.id_division = $request->division";
        
                    $whereraw = preg_replace('/ and/', '', $whereraw, 1); // replace first and
                  $db->whereRaw($whereraw)->get();    	
        
                } 

                $datas = []; 
                $db = $db->get();


            
            foreach($db as $key => $user){
                $datas[$key]= [
                '', $user->name,$user->username,$user->email,$user->division_name,$user->role_name,$user->mobile,$user->nama,$user->active,$user->flag_delete,$user->id_user
                ];
            }
        }
            else if(Auth::user()->id_role == 99){
                $idd = List_user_gudang::get();
                $db = DB::table('users')
                ->select('nama','name','username','list_user_gudang.id','gudang.id', 'email','mobile','users.id_division','division.division_name','users.id_role','role.role_name','id_user','users.active', 'users.flag_delete')
                ->join('list_user_gudang', 'list_user_gudang.id_user', '=', 'users.id')
                ->join('gudang', 'gudang.id', '=', 'list_user_gudang.id_gudang')
                ->join('division', 'division.id_division', '=', 'users.id_division')
                ->join('role', 'role.id_role', '=', 'users.id_role')
                ->whereRaw('list_user_gudang.id_gudang');

                if($request->name != null || $request->gudang != null || $request->email != null || $request->division != null || $request->username != null || $request->role != null || $request->mobile != null || $request->active != null) {
                    $whereraw = '';
        
                    if($request->name != null) $whereraw .= " and users.name like '%$request->name%'";
                    if($request->username != null) $whereraw .= " and users.username like '%$request->username%'";
                    if($request->email != null) $whereraw .= " and users.email like '%$request->email%'";
                    if($request->mobile != null) $whereraw .= " and users.mobile like '%$request->mobile%'";
                    if($request->role != null) $whereraw .= " and users.id_role = $request->role";
                    if($request->gudang != null) $whereraw .= " and gudang.id = $request->gudang";
                    if($request->active != null) $whereraw .= " and users.active = $request->active";
                    if($request->division != null) $whereraw .= " and division.id_division = $request->division";
        
                    $whereraw = preg_replace('/ and/', '', $whereraw, 1); // replace first and
                  $db->whereRaw($whereraw)->get();    	
        
                } 
                    $datas = []; 
                    $db = $db->get();
                    
                    foreach($db as $key => $user){
                        $datas[$key] = [
                            '', $user->name,$user->username,$user->email,$user->division_name,$user->role_name,$user->mobile,$user->nama,$user->active,$user->flag_delete,$user->id_user
                        ];
                    }

                }
            
                    else{
                        if(!$this->access) {
                            Session::flash('message', "you don't have permission to access");
                            return redirect('/http://192.168.0.18/phpv7/project_herca/dashboard_laravel_v1/staging/public/dashboard'); 
                        }
                    }
    	return response()->json(['data' => $datas, 'status' => '200'], 200);
    }
    public function apigetdatauserbyid($id){
        $this->access = Helpers::checkaccess('users', 'view');
        if(!$this->access) return response()->json(['data' => [], 'status' => '401'], 200);

        $datas = User::with('uaccess', 'divisions', 'roles')->where('id', $id)->get();

        return response()->json(['data' => $datas, 'status' => '200'], 200);
    }

    public function apigetdivisi(){
    	$this->access = Helpers::checkaccess('divisi', 'view');
        if(!$this->access) return response()->json(['data' => [], 'status' => '401'], 200);

    	$datas = Division::get();
    	return response()->json(['data' => $datas, 'status' => '200'], 200);
    }
    public function apigetUser(){
    	$this->access = Helpers::checkaccess('divisi', 'view');
        if(!$this->access) return response()->json(['data' => [], 'status' => '401'], 200);

    	$datas = User::get();
    	return response()->json(['data' => $datas, 'status' => '200'], 200);
    }
    public function apigetrole(){
    	$this->access = Helpers::checkaccess('role', 'view');
        if(!$this->access) return response()->json(['data' => [], 'status' => '401'], 200);

    	$datas = Role::where("id_role", "!=", 99)->get();
    	return response()->json(['data' => $datas, 'status' => '200'], 200);
    }
    public function apigetgud(){
    	$this->access = Helpers::checkaccess('role', 'view');
        if(!$this->access) return response()->json(['data' => [], 'status' => '401'], 200);

    	$datas = Gudang::get();
        // dd($datas);
    	return response()->json(['data' => $datas, 'status' => '200'], 200);
    }

    public function apideleteuserbyid($id, Request $request){

    	$this->access = Helpers::checkaccess('users', 'delete');
        if(!$this->access) return response()->json(['data' => ['false'], 'status' => '401'], 200);

    	$datas = User::where('id', $id)->first();
    	
        $datas->flag_delete = 1;
        if(isset($request->undeleted)) $datas->flag_delete = 0;
    	
    	$datas->save();

    	echo 'success';
    }

    public function apiGetDataUserAccessById($id){
        $this->access = Helpers::checkaccess('users', 'view');
        if(!$this->access) return response()->json(['data' => ['false'], 'status' => '401'], 200);

        $datas = Useraccess::where('id_users', $id)->get();
        // dd($datas); 

        return response()->json(['data' => $datas, 'status' => '200'], 200);
    }
    public function apiGetDataUserAccessById2($id){
        $datas = Division::select("default_access")->where('id_division', $id)->first();
        
        return response()->json(['data' => $datas, 'status' => '200'], 200);
    }

    public function apiGetDataListAccess(Request $request){
        $this->access = Helpers::checkaccess('listaccess', 'view');
        if(!$this->access) return response()->json(['data' => $datas, 'status' => '401'], 200);
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

    public function apiGetDataListAccessById($id){
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
