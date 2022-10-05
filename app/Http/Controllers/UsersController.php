<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Division;
use App\Models\Role;
use App\Models\Useraccess;
use App\Models\Listaccess;
use App\Http\Controllers\HelperKuController as Helper;
use App\Models\Gudang;
use Illuminate\Support\Facades\Hash;
use Auth;
use App\Http\Controllers\HelpersController as Helpers;
use App\Models\List_user_gudang;

class UsersController extends AController
{
    public function index(){

    	$this->access = Helpers::checkaccess('users', 'view');
        if(!$this->access) {
            Session::flash('message', "you don't have permission to access");
            return redirect('/dashboard');  
        }

    	$datas = User::get();
    	return view('users.index', array(
            'datas'  => $datas,
        ));
    }

    public function create(){
        $this->access = Helpers::checkaccess('gudang');
    	$this->access = Helpers::checkaccess('users', 'add');
        if(!$this->access) {
            Session::flash('message', "you don't have permission to access");
            return redirect('/dashboard');  
        }

        $divisions = Division::where('active', 1)->get();
        $role = Role::where('active', 1);
        $gudang = gudang::with('users');
        if(Auth::user()->id_role == 1)
        $role = $role->where('id_role', '!=', 1)->where('id_role', '!=', 99);

        else if(Auth::user()->id_role == 99)
                
        $role = $role->where('id_role', '!=', 99);
        $role = $role->get();
        
        if(Auth::user()->id_role == 1){

        $idd = Auth::user()->id;
        $listGudang  = User::with('list_user_gudang', 'gudangs')->where('id', $idd);
        $listGudang = $listGudang->first();

        $datas = []; 
        foreach($listGudang->list_user_gudang as $key  => $data){
            
            $listGudang->list_user_gudang[$key]->nama = Helper::List_gudang_user_form($data->id_gudang);
            $datas[$key]= [
                '', $data->nama,$data->id_gudang
            ];
        }
    }
         if(Auth::user()->id_role == 99){

            $gudang = $gudang->get();
            $datas = [];
            foreach($gudang as $key => $user){
                $datas[$key] = [
                    '', $user->nama,$user->id
                ];
            }
        }
        
        $user_access = Listaccess::where('flag_delete', 0)->get();

    	return view('users.create', array(
            'datas'  => array(
                'users' => array(),
                'divisions' => $divisions,
                'roles' => $role,
                'gudang' => $datas,
                'user_access' => $user_access,
                'urls' => 'store',
            ),
            'id' => ''
        ));
    }
    
    public function store(Request $request){
    
    	$this->access = Helpers::checkaccess('users', 'add');
        if(!$this->access) {
            Session::flash('message', "you don't have permission to access");
            return redirect('/dashboard');  
        }

         $request->validate([
            'email' => 'required|unique:users|max:255',
            // 'body' => 'required',
        ]);

        $id = '';
        $users = New User;
        $users->name = $request->name;
        $users->username = $request->username;
        $users->mobile = $request->mobile;
        $users->email = $request->email;
        if($request->password == '') 'F1rst@1Sampai1';
        $users->password = Hash::make($request->password);
        $users->active = $request->active;
        $users->id_division = $request->id_division;
        $users->id_role = $request->id_role;

        if($users->save()){
            if($request->table_group != ''){
                $explode = explode(', ', $request->table_group);
                foreach($explode as $explode_id){
                    if($explode_id == '') continue;
                        $cari_gudang = List_user_gudang::where('id_user', $users->$id)->where('id_gudang', $explode_id)->first(); // cek apakah pernah di input
                    if(isset($cari_gudang->id)) continue;
                        $listGudang = new List_user_gudang;
                        $listGudang->id_user =$users->id;
                        $listGudang->id_gudang =$explode_id;
                        $listGudang->created_at = date('Y-m-d H:i:s');
                        $listGudang->save();
                }
            }
        }
        if($listGudang->save()){
            Session::flash('message', "Data has been added");
        }
        else {
            return Redirect::back()->withErrors(['msg' => 'The Message']);
        }
        if($request->eCheck1){
            $id = $users->id;
            foreach($request->eCheck1 as $key => $userc){
                foreach($userc as $key2 => $ls) {
                    $users_access = Useraccess::where('id_users', $id)->where('name_access', $key)->where('key_access', $key2)->first();
                    if(!isset($users_access->id_access)) $users_access = new Useraccess;
                    $users_access->id_users = $id;
                    $users_access->name_access = $key; 
                    $users_access->key_access = $key2;
                    $users_access->val_access = $ls;
                    $users_access->save();
                }
            }
        }
        
        if($id){
            return redirect("/users/edit/$id");
        }
        else {
            Session::flash('message', "Upps !!! Something Wrong ... please try again !!!");
            return redirect("/users/create");
        }
    }

    public function apiGetDataUserAccessById($id){
        $this->access = Helpers::checkaccess('users_access', 'view');
        if(!$this->access) return response()->json(['data' => '', 'status' => '401'], 200);
        $datas = Useraccess::where('id_users', $id)->get();
        return response()->json(['data' => $datas, 'status' => '200'], 200);
    }
    public function apiGetDataUserAccessById2($id){
        $this->access = Helpers::checkaccess('users_access', 'view');
        if(!$this->access) return response()->json(['data' => ['success'], 'status' => '401'], 200);

        $datas = Division::select("default_access")->where('id_division', $id)->first();
        return response()->json(['data' => $datas, 'status' => '200'], 200);
    }
    public function tableGudang($id){
        $paket = Gudang::where('id', $id)->get();
            $datas = [];
            foreach($paket as $key => $product){
                $datas[$key] = [
                '',$product->nama,$product->id
                ];
            }
            return response()->json(['data' => $datas, 'status' => '200'], 200);
    }
    public function edit($id){
        $this->access = Helper::cekcek('gudang');
            if(!$this->access) {
                Session::flash('message', "you don't have permission to access");
                return redirect('/dashboard');  
            }
            $division = User::with('divisions')->where('id', $id)->first();
            $divisions = Division::where('active', 1)->get();
            $division = $division->divisions;
            $roles = Role::where('active', 1)->where('id_role', '!=', 99)->get();
            $user_access = Listaccess::where('flag_delete', 0)->get();
            $users = User::where('id', $id)->first();
            $gudang = Gudang::with('users');
                
                if(Auth::user()->id_role == 1){
                    $idd = Auth::user()->id;
                    $listGudang  = User::with('list_user_gudang')->where('id', $idd)->first();
                    $datas = [];
                    foreach($listGudang->list_user_gudang as $key  => $data){
                        $listGudang->list_user_gudang[$key]->nama = Helper::List_gudang_user_form($data->id_gudang);
                        $datas[$key]= [
                            '', $data->nama,$data->id_gudang
                        ];
                    }
                }
        else if(Auth::user()->id_role == 99){
            $gudang = $gudang->get();
            $datas = [];
            foreach($gudang as $key => $user){
                $datas[$key] = [
                    '', $user->nama,$user->id
                ];
            }
        }
        return view('users.edit', array(
            'datas'  => array(
                'users' => $users,
                'divisions' => $divisions,
                'division' => $division,
                'roles' => $roles,
                'gudang' => $datas,
                'user_access' => $user_access,
                'urls' => 'update/'.$id,
            ),
            'id' => $id
        ));
    }
    public function edittable($id){
        if(Auth::user()->id_role == 1){
            $listGudang  = User::with('list_user_gudang')->where('id', $id)->first();
            $datas = [];
            foreach($listGudang->list_user_gudang as $key  => $data){
                $listGudang->list_user_gudang[$key]->nama = Helper::List_gudang_user_form($data->id_gudang);
                $datas[$key]= [
                    '', $data->nama,$data->id_gudang
                ];
            }
        }
        if(Auth::user()->id_role == 99){
        $listGudang  = User::with('list_user_gudang')->where('id', $id)->first();
        $datas = [];
        $i = 1;
        foreach($listGudang->list_user_gudang as $key  => $data){
          $listGudang->list_user_gudang[$key]->nama = Helper::List_gudang_edit($data->id_gudang);
           $datas[$key]= [
           $i++, $data->nama->nama,$data->nama->id
        ];
        }}
        return response()->json(['data' => $datas, 'status' => '200'], 200);
    }
    public function update($id, Request $request){
    	$this->access = Helpers::checkaccess('users', 'edit');
        if(!$this->access) {
            Session::flash('message', "you don't have permission to access");
            return redirect('/dashboard');  
        }
    	$users = User::find($id);
        $users->name = $request->name;
        $users->username = $request->username;
        $users->mobile = $request->mobile;
        $users->email = $request->email;
        $users->id_division = $request->id_division;
        $users->id_role = $request->id_role;
        if($request->password != ''){
            $users->password = Hash::make($request->password);
        }
        $users->active = $request->active;
        if($request->eCheck1){
            foreach($request->eCheck1 as $key => $userc){
                foreach($userc as $key2 => $ls) {
                    $users_access = Useraccess::where('id_users', $id)->where('name_access', $key)->where('key_access', $key2)->first();
                    if(!isset($users_access->id_access)) $users_access = new Useraccess;
                    $users_access->id_users = $id;
                    $users_access->name_access = $key; 
                    $users_access->key_access = $key2;
                    $users_access->val_access = $ls;
                    $users_access->save();
                }
            }
        }
        if($users->update()){
            if($request->table_group != ''){
                $explode = explode(', ', $request->table_group);
                List_user_gudang::where('id_user', $id)->delete();
                foreach($explode as $explode_id){
                    if($explode_id == '') continue;
                        $cari_gudang = new List_user_gudang;
                        $cari_gudang->id_user = $users->id;
                        $cari_gudang->id_gudang = $explode_id;
                        $cari_gudang->updated_at = date('Y-m-d H:i:s');
                        $cari_gudang->save();
                }   
            }
        }
        if($users->update()){
            Session::flash('message', "Data has been updated");
        }
        else 
            Session::flash('message', "Upps Something Wrong ... please try again !!!");
        return redirect("/users/edit/$id");
    }

}
