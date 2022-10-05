<?php

namespace App\Http\Controllers;

use App\Models\Gudang;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\HelpersController as Helpers;
use App\Http\Controllers\HelperKuController as Helper;
use App\Http\Controllers\AlamatController as Calamat;
use App\Models\list_product;
use App\Models\List_user_gudang;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GudangController extends AController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->access = Helpers::checkaccess('warehouse', 'view');
        if(!$this->access) {
            Session::flash('message', "you don't have permission to access");
            return redirect('/dashboard');  
        }
        $users = User::with('roles');
        if(Auth::user()->id_role == 99)
        $users = $users->where('id_role', '!=', 99);
        if(Auth::user()->id_role == 1)
        $users = $users->where('id_role', '!=', 1)->where('id_role', '!=', 99);
        $users = $users->get();
        
        $user = User::where('id_role', '!=', 99)->get();
        $product = Product::where('id', '!=', 0)->get();

     return view("gudang.index",array(
         'datas'  => array(
             'user' => $users,
             'title' => 'Warehouse',
             'product' => $product
         )
         ));
    }
    public function gudanggetdata(Request $request){
        $this->access = Helpers::checkaccess('warehouse', 'view');
        if(!$this->access) {
            Session::flash('message', "you don't have permission to access");
            return redirect('/dashboard');  
        }
        $gudang = gudang::with('users');
        if($request->nama != null || $request->alamat != null|| $request->alias_gudang != null|| $request->active != null) {
            $whereraw = '';
            if($request->nama != null) $whereraw .= " and nama like '%$request->nama%'";
            if($request->alamat != null) $whereraw .= " and alamat like '%$request->alamat%'";
            if($request->alias_gudang != null) $whereraw .= " and alias_gudang like '%$request->alias_gudang%'";
            if($request->active != null) $whereraw .= " and active like '%$request->active%'";
            
            $whereraw = preg_replace('/ and/', '', $whereraw, 1);
            $gudang = $gudang->whereRaw($whereraw)->where('active', '!=', 2);
        }
        else if(Auth::user()->id_role == 1){
            $idd = Auth::user()->id;
            $listGudang  = User::with('list_user_gudang', 'gudangs')->where('id', $idd);
            $listGudang = $listGudang->first();

            $datas = []; 
            foreach($listGudang->list_user_gudang as $key  => $data){
                $listGudang->list_user_gudang[$key]->nama = Helper::List_gudang_edit($data->id_gudang);
                $datas[$key]= [
                    '', $data->nama->nama,$data->nama->alamat,$data->nama->alias_gudang,$data->nama->active,$data->nama->flag_delete,$data->id_gudang
                ];
            }
        }
        else{
            $gudang = $gudang->get();
            $datas = [];
            foreach($gudang as $key => $user){
                $datas[$key] = [
                    '', $user->nama,$user->alamat,$user->alias_gudang,$user->active,$user->flag_delete,$user->id
                ];
            }
        }
        return response()->json(['data' => $datas, 'status' => '200'], 200);
    }
     
    public function listgudanggetdata($id){
        $listProduct  = list_product::with('products')->where('id_gudang', $id)->get();
        $datas = [];
        $i = 1;
        foreach($listProduct as $key => $product){
            $datas[$key] = [
                $i++,$product->products[0]->nama,$product->stock
            ];
        }

        return response()->json(['data' => $datas, 'status' => '200'], 200);

    }   
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { $this->access = Helpers::checkaccess('warehouse', 'view');

        $validator = Validator::make($request->all(), [
      
            'nama' => 'required',
            'alias_gudang' => 'required',
            'alamat' => 'required',
          
        ],[
         'nama.required' => 'Nama Gudang Tidak Boleh Kosong',
         'alias_gudang.required' => 'Alias Gudang  Tidak Boleh Kosong',
         'alamat.required' => 'Alamat Tidak Boleh Kosong',
         
        ]);
         
        if ($validator->fails()) {
         return response()->json(['errors'=>$validator->errors()->all()]);
     }

     $datas = new Gudang();
     $datas->nama = $request->nama;
     $datas->alias_gudang = $request->alias_gudang;
     $datas->alamat = $request->alamat;
     $datas->active = $request->active;


     if($datas->save()){
        if($request->user_group != ''){
            $explode = explode(', ', $request->user_group);
            foreach($explode as $explode_id){
                if($explode_id == '') continue;

                $cariuser = List_user_gudang::where('id_user', $explode_id)->where('id_gudang', $datas->id)->first(); // cek apakah pernah di input
                if(isset($cariuser->id)) continue;

                $user = new List_user_gudang;
                $user->id_user = $explode_id;
                $user->id_gudang = $datas->id;
                $user->created_at = date('Y-m-d H:i:s');
                $user->save(); // tambah kan user baru berdasarkan id gudang
            }

            
        }
        $products = Product::get();
        foreach($products as $product){
            $listProduct = list_product::where('id_gudang', $datas->id)->where('id_product', $product->id)->first();
            if(isset($listProduct->id)) continue;
            else{
                $listProduct = new list_product;
                
                $listProduct->id_gudang =$datas->id;
                $listProduct->id_product =$product->id;
                $listProduct->created_at = date('Y-m-d H:i:s');
                $listProduct->save();
            }
        }

     }
     
                    
     return response()->json(['data' => ['success'], 'status' => '200'], 200);

    }
  

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gudang  $gudang
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $tatas  = Gudang::with('list_user_gudang')->where('id', $id)->first();
        foreach($tatas->list_user_gudang as $key  => $data){
            $tatas->list_user_gudang[$key]->nama = Calamat::User_gudang($data->id_user);

        }
        return response()->json(['data' => $tatas, 'status' => '200'], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gudang  $gudang
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $tatas  = Gudang::with('list_user_gudang')->where('id', $id)->first();
        foreach($tatas->list_user_gudang as $key  => $data){
            $tatas->list_user_gudang[$key]->nama = Calamat::User_gudang($data->id_user);
        }
      return response()->json(['data' => $tatas, 'status' => '200'], 200);
    }

    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gudang  $gudang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
      
            'nama' => 'required',
            'alias_gudang' => 'required',
            'alamat' => 'required',
            'user_group' => 'required',
          
        ],[
         'nama.required' => 'Nama Gudang Tidak Boleh Kosong',
         'alias_gudang.required' => 'Alias Gudang  Tidak Boleh Kosong',
         'alamat.required' => 'Alamat Tidak Boleh Kosong',
         'user_group.required' => 'User Tidak Boleh Kosong',
         
        ]);
         
        if ($validator->fails()) {
         return response()->json(['errors'=>$validator->errors()->all()]);
     }

     $datas = Gudang::where('id', $id)->first();
     $datas->nama = $request->nama;
     $datas->alias_gudang = $request->alias_gudang;
     $datas->alamat = $request->alamat;
     $datas->active = $request->active;


     if($datas->update()){
        if($request->user_group != ''){
            $explode = explode(', ', $request->user_group);
            List_user_gudang::where('id_gudang', $id)->delete(); // cek 

            foreach($explode as $explode_id){

                if($explode_id == '') continue;
                $cariuser = List_user_gudang::where('id_user', $explode_id)->where('id_gudang', $datas->id)->first(); // cek apakah pernah di input
                if(isset($cariuser->id)) continue;

                $user = List_user_gudang::where('id', $id)->first();

                if(!isset($user->id)) {
                    $user = new List_user_gudang;
                    $user->id_user = $explode_id;
                    $user->id_gudang = $id;
                    $user->created_at = date('Y-m-d H:i:s');
                    $user->save(); // tambah kan user baru berdasarkan id gudang
                } else {
                    $user->id_user = $explode_id;
                    $user->id_gudang = $id;
                    $user->updated_at = date('Y-m-d H:i:s');
                    $user->save(); // Update user berdasarkan id gudang
                }
                
            }
        }


     }
     
                    
     return response()->json(['data' => ['success'], 'status' => '200'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gudang  $gudang
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gudang $gudang, Request $request, $id)
    {
        $datas = Gudang::where('id',$id)->first();
        $datas->flag_delete = 1;

        if(isset($request->undeleted)) $datas->flag_delete = 0;
        $datas->save();
    
        return response()->json(['data' => $datas, 'status' => '200'], 200);;
    }
}
