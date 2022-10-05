<?php

namespace App\Http\Controllers;

use App\Models\Gudang;
use App\Models\List_user_gudang;
use DB;
use Auth;

class HelperKuController extends AController
{
    public function List_gudang_User($id_gudang = 0){
        $datas = '';
        if($id_gudang != 0) {
           $datas = Gudang::select('nama', 'id')->where('id', $id_gudang)->first(); 
           $vp = json_decode($datas);
           return $vp->nama;
        }
        return $datas;
    }

    public function List_gudang_edit($id_gudang = 0){
        $datas = '';
        if($id_gudang != 0) {
           $datas = Gudang::select('nama','id', 'alamat','alias_gudang','active', 'flag_delete' )->where('id', $id_gudang)->first(); 
           $vp = $datas;
           return $vp;
        }

        return $datas;

    }

    public function List_gudang_user_form($id_gudang = 0){
        $datas = '';
        if($id_gudang != 0) {
           $datas = Gudang::select('nama','id' )->where('id', $id_gudang)->first(); 
           $vp = $datas;
           return $vp->nama;
        }
        return $datas;
    }
    public static function cekcek($cekcek = 0){
        if(Auth::user()->id_role == 99) return true;
        $idd = Auth::user()->id;
        $listGudang  = List_user_gudang::with('users')->where('id_user', $idd);
        
        $listGudang = $listGudang->first();

        $id = $listGudang->id_gudang;

        if($cekcek != '')
            $checkaccess =  DB::table('users')
            ->select('list_user_gudang.id_gudang')
            ->join('list_user_gudang', 'list_user_gudang.id_user', '=', 'users.id')
            ->where('list_user_gudang.id_gudang', $id)
            ->first();
            if(isset($checkaccess->id_gudang) && $checkaccess->id_gudang != '') {
                return true;
            }
        return false;
    }
    public function List_gudang_user_apis($id_gudang = 0){
        $datas = '';
        if($id_gudang != 0) {
           $datas = Gudang::select('nama','id' )->where('id', $id_gudang)->first(); 
           $vp = $datas;
           return $vp;
        }
        return $datas;
    }
    public function List_gudang_user_table($id_gudang = 0){
        $datas = [];
        if($id_gudang != 0) {
            $datas = DB::table('users')
            ->select('nama','name','username', 'email','mobile','id_division','id_role','id_user','users.active', 'users.flag_delete')
            ->join('list_user_gudang', 'list_user_gudang.id_user', '=', 'users.id')
            ->join('gudang', 'gudang.id', '=', 'list_user_gudang.id_gudang')
            ->where('users.id_role', '!=', 1)
            ->where('gudang.id', $id_gudang)
            ->get();

        foreach($datas as $key => $user){
            $datas[$key]= [
                '', $user->name,$user->username,$user->email,$user->id_division,$user->id_role,$user->mobile,$user->active,$user->flag_delete,$user->id_user
            ];
        }
        $vp = $datas;
           return $vp;
        }


    }
    
}
