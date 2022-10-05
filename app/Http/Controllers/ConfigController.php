<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Division;
use App\Models\Role;
use App\Models\Config;
use App\Models\Useraccess;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\HelpersController as Helpers;


class ConfigController extends Controller
{
    public function index(){
        $this->access = Helpers::checkaccess('config', 'view');
        if(!$this->access) {
            Session::flash('message', "you don't have permission to access");
            return redirect('/dashboard');  
        }

        $datas = Config::get();
        return view('config.index', array(
            'datas'  => $datas,
        ));
    }


    public function apiGetData(Request $request){
    	$this->access = Helpers::checkaccess('config', 'view');		
        if(!$this->access) return response()->json(['data' => $datas, 'status' => '401'], 200);

        
    	if($request->nama != null || $request->content != null || $request->ket != null || $request->active != null ) {
    		$whereraw = '';

    		if($request->nama != null) $whereraw .= " and nama like '%$request->nama%'";
    		if($request->content != null) $whereraw .= " and content like '%$request->content%'";
    		if($request->ket != null) $whereraw .= " and flag_ket like '%$request->ket%'";
    		if($request->active != null) $whereraw .= " and active = $request->active";

    		$whereraw = preg_replace('/ and/', '', $whereraw, 1); // replace first and
    		$config = Config::whereRaw($whereraw)->get();    	

    	} else {
    		$config = Config::get();
    	}
        

    	$datas = [];
    	foreach($config as $key => $conf){
    		$datas[$key] = [
    			'', $conf->nama, $conf->content, $conf->flag_ket, $conf->active, $conf->id
    		];
    	}

    	return response()->json(['data' => $datas, 'status' => '200'], 200);
    }


    public function apiInsertData(Request $request){
        $this->access = Helpers::checkaccess('config', 'add');
        if(!$this->access) return response()->json(['data' => ['false'], 'status' => '401'], 200);

        $validator = Validator::make($request->all(), [
           'nama' => 'required|unique:config',
           'content' => 'required',
       ]);
        
       if ($validator->fails()) {
            return response()->json(['data' => [$validator->messages()->first()], 'status' => '401'], 200);
       }

        $datas = new config;
        $datas->nama = $request->nama;
        $datas->content = $request->content;
        $datas->flag_ket = $request->flag_ket;
        $datas->active = $request->active;

        if($datas->save())
            return response()->json(['data' => ['success'], 'status' => '200'], 200);
        else 
            return response()->json(['data' => ['false'], 'status' => '200'], 200);
    }


    public function apiUpdateDataById($id, Request $request){
        $this->access = Helpers::checkaccess('config', 'edit');
        if(!$this->access) return response()->json(['data' => ['false'], 'status' => '401'], 200);

        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'content' => 'required',
       ]);
        
       if ($validator->fails()) {
            return response()->json(['data' => [$validator->messages()->first()], 'status' => '401'], 200);
       }

       $bundling = Config::where('nama', $request->nama)->first();
       if (isset($bundling->id) && $bundling->id != $id) {
            return response()->json(['data' => [false, 'nama sudah ada'], 'status' => '401'], 200);
       }

        $datas = Config::where('id', $id)->first();
        $datas->nama = $request->nama;
        $datas->content = $request->content;
        $datas->flag_ket = $request->flag_ket;
        $datas->active = $request->active;

        if($datas->save())
            return response()->json(['data' => ['success'], 'status' => '200'], 200);
        else 
            return response()->json(['data' => ['false'], 'status' => '200'], 200);
    }

    public function apiGetDataById($id, Request $request)
    {
        $this->access = Helpers::checkaccess('config', 'view');		
        if(!$this->access) return response()->json(['data' => [], 'status' => '401'], 200);        

    	$datas = Config::where('id', $id)->get();
    	

    	return response()->json(['data' => $datas, 'status' => '200'], 200);
    }

    public function apiDeleteConfigById($id, Request $request){

    	$this->access = Helpers::checkaccess('config', 'delete');
        if(!$this->access) return response()->json(['data' => ['false'], 'status' => '401'], 200);

    	$datas = Config::where('id', $id)->get();
        // dd($datas);

    	$datas->flag_delete = 1;

        dd($datas->flag_delete, $datas);

        if($request->undeleted != '') $datas->flag_delete = 0;


    	$datas->save();

    	echo 'success';
    }


}
