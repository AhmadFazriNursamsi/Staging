<?php

namespace App\Http\Controllers;

use App\Models\Gudang;
use App\Models\List_user_gudang;
use App\Models\Loc_city;
use App\Models\User;
use App\Models\Loc_district;
use App\Models\Loc_province;
use App\Models\Loc_village;
use App\Models\Product;
use DB;
use Illuminate\Http\Request;

class AlamatController extends AController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }


    public function alamatgetById($id){
            $datas = Loc_province::where('id', $id)->get();
            return response()->json(['data' => $datas, 'status' => '200'], 200);
            }
    public function User_gudang($id_user = 0){
        $datas = '';
        if($id_user != 0) {
            $datas = User::select('name')->where('id', $id_user)->first(); 
            return $datas->name;
        }
        return $datas;
    }
    public function detail_paket_id($id_product = 0){
        $datas = '';
        if($id_product != 0) {
            $db = DB::table('products')
            ->select('satuans.id','nama', 'satuans.satuan_name', 'products.nama')
            ->join('satuans', 'satuans.id', '=', 'products.satuan_id')
            ->where('products.id', $id_product)
            ->first();
            $vp =$db;
            // dd($vp);
            return $vp;
        }
        return $datas;

    }
    public static function coba2(){
        $cities  = List_user_gudang::with('users')->first();                    
        $output = [];
        foreach( $cities as $city )
        {
            $output = $city->name;
        }
        return response()->json(['data' => $output, 'status' => '200'], 200);
    }
    public function alamatgetByIdCity(Request $request){
        $this->validate( $request, [ 'id' => 'required' ] );
        $cities = Loc_city::where('province_id', $request->get('id') )->get();
        $output = [];
        foreach( $cities as $city )
        {
           $output[$city->id] = $city->name;
        }
        return response()->json(['data' => $output, 'status' => '200'], 200);
    }

    public function alamatgetByIdKab(Request $request){
        $this->validate( $request, [ 'id' => 'required' ] );
        $cities = Loc_district::where('city_id', $request->get('id') )->get();
        $output = [];
        foreach( $cities as $city )
        {
           $output[$city->id] = $city->name;
        }
        return response()->json(['data' => $output, 'status' => '200'], 200);
    }

    public function alamatgetByIdKel(Request $request){
        $this->validate( $request, [ 'id' => 'required' ] );
        $cities = Loc_village::where('district_id', $request->get('id') )->get();
        $output = [];
        foreach( $cities as $city )
        {
           $output[$city->id] = $city->name;
        }
        return response()->json(['data' => $output, 'status' => '200'], 200);
    }
    public static function alamatgetByIdCity2($id){
        $cities = Loc_city::where('id', $id )->get();
        $output = [];
        foreach( $cities as $city )
        {
           $output = $city->name;
        }
        return response()->json(['data' => $output, 'status' => '200'], 200);
    }

    public function List_gudang_User($id_gudang = 0){
        $datas = '';
        if($id_gudang != 0) {
           $datas = Gudang::select('nama', 'id')->where('id', $id_gudang)->first(); 
           $vp = json_decode($datas);
           return $vp;
        }
        return $datas;
    }

    public static function alamatgetByIdKab2($id){
        $cities = Loc_district::where('id', $id )->get();
        $output = [];
        foreach( $cities as $city )
        {
           $output = $city->name;
        }
        return response()->json(['data' => $output, 'status' => '200'], 200);
    }

    public static function alamatgetByIdKel2($id){
        $cities = Loc_village::where('id', $id )->get();
        $output = [];
        foreach( $cities as $city )
        {
           $output = $city->name;
        }
        return response()->json(['data' => $output, 'status' => '200'], 200);
    }
    public function alamatgetByIdDistrict($id){
        $datas = Loc_district::where('id', $id)->get();
        return response()->json(['data' => $datas, 'status' => '200'], 200);
    }

    public function alamatVillage($id){
        $datas = Loc_village::where('id', $id)->get();
        return response()->json(['data' => $datas, 'status' => '200'], 200);
    }

}
