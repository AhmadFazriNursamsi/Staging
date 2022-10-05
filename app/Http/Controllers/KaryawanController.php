<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\HelpersController as Helpers;
use App\Notifications\WelcomeEmailNotification;
use App\Http\Controllers\AlamatController as Calamat;
use Illuminate\Support\Facades\Session;
use App\Models\Alamat;
use App\Models\Karyawan;
use App\Models\Loc_province;
use Auth;
use Illuminate\Support\Facades\Validator;

class KaryawanController extends AController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getdata(Request $request){
    // $users = $users->get();
    
    $karyawan = Karyawan::get();
    // dd($karyawans);


    	$datas = [];
		foreach($karyawan as $key => $karyawan){
            if($karyawan->logo == 0) {
                $karyawan->logo = 'default.jpg';
            }

    		$datas[$key] = [
    			$karyawan->nama,'',$karyawan->logo,'', $karyawan->id
    		];
    	}
    	return response()->json(['data' => $datas, 'status' => '200'], 200);
    }


    public function index()
    {
        $karyawan = Karyawan::get();
        // dd($karyawan);

        $this->access = Helpers::checkaccess('customers', 'view');
        if(!$this->access) {
            Session::flash('message', "you don't have permission to access");
            return redirect('/dashboard');  
        }
   
        return view("karyawan.index", array(
            'datas'  => array(
                'karyawan' => $karyawan,
                'title' => 'Karyawan'
            )
            ));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        // dd($request);
        // $this->access = Helpers::checkaccess('customer', 'add');
        // if(!$this->access) return response()->json(['data' => ['false'], 'status' => '401'], 200);
        
        
        $validator = Validator::make($request->all(), [
            
            'website' => 'required',
            'email' => 'unique:karyawan|email|required',
           'last_name'=> 'required',
           'first_name'=> 'required',     
       ],[
   
        'email.unique' => 'Email Sudah Terdaftar!',
        'email.required' => 'Email Tidak Boleh Kosong',
        'first_name.required' => 'First Name Tidak Boleh Kosong',
        'last_name.required' => 'Last Name Tidak Boleh Kosong',
        'website.required' => 'website Tidak Boleh Kosong',

       ]);
        
    //    dd('test');
       if ($validator->fails()) {
           return response()->json(['errors'=>$validator->errors()->all()]);
    }        
    $datas = new Karyawan;
     $datas->first_nama = $request->first_name;
     $datas->last_nama = $request->last_name;
     $first = $datas->first_nama;
     $last = $datas->last_nama; 
     $first .= $last;
     $datas->nama = $first;
     $datas->email = $request->email;
     
    //  dd($request->file('logo'));
    //  $datas->logo = $request->logo->move(public_path('images'), $imageName);
    
    //  if ($request->file() == null)  
 
    if ($request->file() != null) 
        $datas->logo = Helpers::generateKodekaryawan($first, $last);                            
        $helperuntukupload = Helpers::uploadImage($request, $datas->logo);
        $datas->logo = $helperuntukupload;
    
     $datas->website = $request->website;
    $datas->save();

    $datas->notify(new WelcomeHelpersEmailNotification($datas));

            return response()->json(['data' => ['success'], 'status' => '200'], 200);
        
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Karyawan  $karyawan
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $datas = Karyawan::where('id', $id)->first();
        // dd($datas);

        return response()->json(['data' => $datas, 'status' => '200'], 200);
    }
    public function edit($id){
        // dd($id);
        $datas = Karyawan::where('id', $id)->first();
        // dd($datas);

        return response()->json(['data' => $datas, 'status' => '200'], 200);
    }
    public function update(Request $request, $id){
        
        $datas = Karyawan::where('id', $id)->first();
        $datas->first_nama = $request->first_name;
        $datas->last_nama = $request->last_name;
        $first = $datas->first_nama;
        $last = $datas->last_nama; 
        $first .= $last;
        $datas->nama = $first;
        $datas->email = $request->email;

        if ($request->file() != null) 
        $datas->logo = Helpers::generateKodekaryawan($first, $last);                            
        $helperuntukupload = Helpers::uploadImage($request, $datas->logo);
        
        $datas->logo = $helperuntukupload;
        $datas->website = $request->website;
        $datas->save();

        return response()->json(['data' => ['success'], 'status' => '200'], 200);
    }

    // public function show($id, Request $request)
    // {
    //     $this->access = Helpers::checkaccess('customer', 'view');
    //     if(!$this->access) return response()->json(['data' => ['false'], 'status' => '401'], 200);
    //     $dd = Alamat::get();
    //         $tatas  = Customer::with('alamats')->where('id', $id)->first();

    //         foreach($tatas->alamats as $key => $data){
    //             $tatas->alamats[$key]->province = Calamat::alamatgetById($data->province, $request)->original['data'];
    //             $tatas->alamats[$key]->city = Calamat::alamatgetByIdCity2($data->city)->original['data'];
    //             $tatas->alamats[$key]->district = Calamat::alamatgetByIdKab2($data->district)->original['data'];
    //             $tatas->alamats[$key]->village = Calamat::alamatgetByIdKel2($data->village)->original['data'];
    //         }
      
    //     return response()->json(['data' => $tatas, 'status' => '200'], 200);
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  \App\Models\Customer  $customer
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit($id)
    // {
    //     $this->access = Helpers::checkaccess('customer', 'edit');
    //     if(!$this->access) return response()->json(['data' => ['false'], 'status' => '401'], 200);

    //     $tatas  = Customer::with('alamats')->where('id', $id)->first();
    //     return response()->json(['data' => $tatas ,'status' => '200'], 200);
 
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \App\Models\Customer  $customer
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update($id, Request $request, Customer $customer)
    // {
    //     $this->access = Helpers::checkaccess('customer', 'edit');
    //     if(!$this->access) return response()->json(['data' => ['false'], 'status' => '401'], 200);

    //     $validator = Validator::make($request->all(), [
      
    //         'email' => 'email',
    //         'no_tlp' => 'numeric',
    //         'name_Provinsi' => 'required',
    //         'name_kecamatan'=> 'required',
    //         'name_kelurahan'=> 'required',   
    //         'name_kelurahan'=> 'required',
    //         'name_alamat'=> 'required',     
    //     ],[
    
    //      'no_tlp.numeric' => 'Nomor Telepon Harus Berbentuk Angka!',
    //      'name_Provinsi.required' => 'Alamat Provinsi Tidak Boleh Kosong',
    //      'name_kabupaten.required' => 'Alamat Kabupaten Tidak Boleh Kosong',
    //      'name_kecamatan.required' => 'Alamat Kecamatan Tidak Boleh Kosong',
    //      'name_kelurahan.required' => 'Alamat Kelurahan Tidak Boleh Kosong',
    //      'name_alamat.required' => 'Alamat Detail     Tidak Boleh Kosong',
         
    //     ]);
         
    //     if ($validator->fails()) {
    //      return response()->json(['errors'=>$validator->errors()->all()]);
    //  }
    //     $tatas = Customer::where('id', $id)->first();
    //     $tatas->name = $request->name;
    //     $tatas->email = $request->email;
    //     $tatas->no_tlp = $request->no_tlp;
    //     $tatas->active = $request->active;
    //     if($tatas->update()){
    //         $alamat = Alamat::where('id_customer', $id)->first();
    //         $alamat->province = $request->name_Provinsi;
    //         $alamat->city = $request->name_kabupaten;
    //         $alamat->district = $request->name_kecamatan;
    //         $alamat->village = $request->name_kelurahan;
    //         $alamat->alamat = $request->name_alamat;
    //         $alamat->created_at = date('Y-m-d H:i:s');
    //         $alamat->id_customer=$tatas->id;
    //         $alamat->update(); 
    //         return response()->json(['data' => ['success'], 'status' => '200'], 200);
    //     }else{

    //         return response()->json(['data' => ['false'], 'status' => '200'], 200);
    //         } 
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  \App\Models\Customer  $customer
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy(Request $request, $id)
    // {
    //     $this->access = Helpers::checkaccess('customer', 'delete');
    //     if(!$this->access) return response()->json(['data' => ['false'], 'status' => '401'], 200);

	// 	$datas = Customer::where('id',$id)->first();
    //     $datas->flag_delete = 1;

    //     if(isset($request->undeleted)) $datas->flag_delete = 0;
    //     $datas->save();
    
    //     return response()->json(['data' => $datas, 'status' => '200'], 200);;
    
    // }
}
