<?php

namespace App\Http\Controllers;

// model
use App\Models\Brand;
use App\Models\Config;
use App\Models\Gudang;
use App\Models\Satuan;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\ListProduct;
use App\Models\HistoryProducts;
use App\Models\HistoryProductsDelete;
// model

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\AController;
use App\Http\Controllers\HelpersController as Helpers;

class ProductsController extends AController
{
    public function index()
    {      

        $this->access = Helpers::checkaccess('products', 'view');
        if(!$this->access) {
            Session::flash('message', "you don't have permission to access");
            return redirect('/dashboard');  
        }

        $datas = Product::get();
        $generateqrcode = Helpers::generateqrcode();

        // $request, $datas->kode_products);        
        return view('products.index', array(
            'datas' => $datas,
            'satuans' => Satuan::where('id','!=', 0)->orderBy('id', 'ASC')->get(),
            'categories' => Category::where('id','!=', 0)->orderBy('category_name', 'ASC')->get(),
            'brands' => Brand::where('id','!=', 0)->orderBy('brand_name', 'ASC')->get(),
            'suppliers' => Supplier::where('id','!=', 0)->orderBy('supplier_name', 'ASC')->get(),
            'generateqrcode' => $generateqrcode
        ));        
    }
    
    public function apiGetData(Request $request)
    {
        $this->access = Helpers::checkaccess('products', 'view');		
        if(!$this->access) return response()->json(['data' => [], 'status' => '401'], 200);

        if($request->nama != null || $request->barcode != null || $request->satuan_id != null || $request->slug != null || $request->active != null ) 
        {
            $whereraw = '';
            
            if($request->nama != null) $whereraw .= " and nama like '%$request->nama%'";
            if($request->barcode != null) $whereraw .= " and barcode like '%$request->barcode%'";
            if($request->satuan_id != null) $whereraw .= " and satuan_id like '%$request->satuan_id%'";
            if($request->slug != null) $whereraw .= " and slug like '%$request->slug%'";
            if($request->active != null) $whereraw .= " and active = $request->active";

    		$whereraw = preg_replace('/ and/', '', $whereraw, 1); // replace first and
            $products = Product::whereRaw($whereraw)->with('satuans')->get();    	
            // dd($products);
        } else {
        $products = Product::with('satuans')->get();
    }

        // $products = Product::with('satuans')->get();
        $datas = [];
        foreach($products as $key => $value)
        {
            // dd($value->satuans);
            if($value->image == "") {
                $value->image = 'nopic.jpg';
            }
            $datas[$key] = [
                '', 
                $value->image,
                $value->nama,
                $value->barcode,
                // dd($value->satuans[$key]->satuan_name), 
                // detailPreOrder[0]->jumlah_produk
                $value->satuans[0]->satuan_name,
                $value->slug,
                $value->active,
                $value->id,
                $value->deskripsi,
                $value->spesifikasi,
                    
            ];
            // dd($datas[$key]);
        }
        return response()->json(['data' => $datas, 'status' => '200'], 200);
    }

    // ---------------------------------------------------------- INSERT DATA ----------------------------------------------------------

    public function apiInsertData(Request $request)
    {
        $this->access = Helpers::checkaccess('products', 'add');
        if(!$this->access) return response()->json(['data' => ['false'], 'status' => '401'], 200);

        // dd($request);
        $validator = Validator::make($request->all(), [
            'nama' => 'required|min:4|unique:products',
            'active' => 'required',
            'kode_products' => 'required|min:3|max:10|unique:products',
        ], [
            'nama.unique' => 'Nama Produk Tidak Boleh Sama',
            'kode_products.unique' => 'Kode Produk Tidak Boleh Sama',   
            'nama.required' => 'Nama Harus Di Isi',
            'kode_products.required' => 'Kode Products Harus Di Isi'

        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors'=> $validator->errors()->all()]);
        }

        $config_barcode = date('YmdHis');
        $generateqrcode = Helpers::generateqrcode('text');    

        $datas = new Product;
        $datas->nama = $request->nama;       
        $datas->slug = Str::slug($request->nama, '_');
        $datas->barcode = $config_barcode;
        $datas->active = $request->active;
        $datas->spesifikasi = $request->spesifikasi;
        
        // if($request->deskripsi == "null")
        $datas->deskripsi = $request->deskripsi;

        // if($request->spesifikasi == "null")
        $datas->spesifikasi = $request->spesifikasi;

        // Set Jika Tidak Di Pilih akan Default 0
        if($request->satuan_id == "null")
        $request->satuan_id = 0;
        // dd($request->satuan_id = 0);
        $datas->satuan_id = $request->satuan_id;

        // Set Jika Tidak Di Pilih akan Default 0
        if($request->supplier_id == "null")
        $request->supplier_id = 0;
        $datas->supplier_id = $request->supplier_id;
        
        // Set Jika Tidak Di Pilih akan Default 0
        if($request->category_id == "null")
        $request->category_id = 0;
        $datas->category_id = $request->category_id;
        
        // Set Jika Tidak Di Pilih akan Default 0
        if($request->brand_id == "null")
        $request->brand_id = 0;
        $datas->brand_id = $request->brand_id;

        $datas->created_at = date('Y-m-d H:i:s');
        $datas->updated_at = date('Y-m-d H:i:s');
        // $datas->updated_by = $datas->id; // create baru
        // $datas->created_by = $datas->id;

        $datas->updated_by = Auth::user()->id; // sipaa yg ngebuat dan update
        $datas->created_by = Auth::user()->id; 

        if($request->kode_products != null)
        {
            $helperkode_products = Helpers::kodeproduk($request->kode_products);
            $datas->kode_products = $helperkode_products;
        }

        // proses upload image


        if ($request->file() != null) 
        {
            $datas->image = Helpers::generateKodeProducts($request->nama, $request->category_id, $request->brand_id);                            
            $helperuntukupload = Helpers::uploadImage($request, $datas->image);
            $datas->image = $helperuntukupload;
        } 

        // Proses QR CODE
        if($datas->save())
        {
            $url_qr_code = Config::where('nama','url_barcode')->first();
            if(isset($url_qr_code->nama))
                $url_qr_code = $url_qr_code->content;
            $value_qr_code = $url_qr_code.'HRC-'.strtotime(date('YmdHis')).rand(0,9).rand(0,9).$datas->id;
            $generateqrcode = Helpers::generateqrcode($value_qr_code);    
            $datas->qr_code = json_decode($generateqrcode)->data[0];
            $datas->url_qr_code = $value_qr_code;      

            $gudang = Gudang::get();
            // dd($gudang);
            foreach ($gudang as $gudangNew) {
                $idGudang1 = $gudangNew->id; 
                $idProductBaru = $datas->id; // create Product Baru

                $checkListProduct = ListProduct::where('id_gudang', $idGudang1)->where('id_product', $idProductBaru)->first(); // cuma datapat 1
                if (isset($checkListProduct->id))continue; 
                else {
                    $listProduct = new ListProduct;
                    $listProduct->id_gudang = $idGudang1;
                    $listProduct->id_product = $idProductBaru;
                    $listProduct->stock = 0;
                    $listProduct->created_at = date('Y-m-d H:i:s');
                    $listProduct->save();
                } 
            } 
            
            $datas->save();
            return response()->json(['data' => ['success'], 'status' => '200'], 200);
        } else 
        return response()->json(['data' => ['false'], 'status' => '200'], 200);
    }

    // ---------------------------------------------------------- INSERT DATA ----------------------------------------------------------

    public function apiUpdateDataById($id, Request $request)
    {
        $this->access = Helpers::checkaccess('products', 'edit');
        if(!$this->access) return response()->json(['data' => ['false'], 'status' => '401'], 200);
        // dd($request);

        $validator = Validator::make($request->all(), [
            
        ]);
        
        if ($validator->fails()) {
            return response()->json(['data' => [$validator->messages()->first()], 'status' => '401'], 200);
        }
        
        // validasi untuk merubah nama success
        $bundling = Product::where('nama', $request->nama)->first();
        if (isset($bundling->id) && $bundling->id != $id) 
        {
        return response()->json(['data' => [false, 'nama sudah ada'], 'status' => '401'], 200);
        }
        // validasi untuk merubah nama success            

        $config_barcode = date('YmdHis');
        
        $modelProducts = Product::where('id', $id)->first();
        // $modelProducts->nama = $request->nama;
        $modelProducts->slug = Str::slug($request->nama, '_');
        $modelProducts->barcode = $config_barcode;
        $modelProducts->satuan_id = $request->satuan_id;
        $modelProducts->active = $request->active;
        $modelProducts->spesifikasi = $request->spesifikasi;
        $modelProducts->supplier_id = $request->supplier_id;
        $modelProducts->category_id = $request->category_id;
        $modelProducts->brand_id = $request->brand_id;
        $modelProducts->updated_by = Auth::user()->id; // sipaa yg ngebuat dan update

        $modelProducts->updated_at = date('Y-m-d H:i:s'); 
        
        $created_at_lama = $modelProducts->created_at; // value lama
        $modelProducts->created_at = date('Y-m-d H:i:s'); // value baru
        
        $created_by_lama = $modelProducts->created_by; // value lama
        $modelProducts->created_by = Auth::user()->id; // value baru
        // $modelProducts->created_by = $request->id;
        
        $kodelama = $modelProducts->kode_products; // value lama
        $modelProducts->kode_products = Helpers::kodeproduk($request->kode_products); // value baru
        
        $namalama = $modelProducts->nama; // value lama
        $modelProducts->nama = $request->nama; // value baru

        $deskripsilama = $modelProducts->deskripsi; // value lama
        $modelProducts->deskripsi = $request->deskripsi; // value baru
        
        // dd($request->file() ,$request->file() == null  ,'test', $request)->file('image');
        if ($request->file() != null) 
        {
            $gambarlama = $modelProducts->image; 
            $modelProducts->image = Helpers::generateKodeProducts($request->nama, $request->category_id, $request->brand_id);
            $helperuntukupload = Helpers::uploadImage($request, $modelProducts->image);
            // dd($helperuntukupload);
            // dd($helperuntukupload);
            if (File::exists("images/uploads/{$gambarlama}")) 
            {
                File::delete("images/uploads/{$gambarlama}");
            }

            if (File::exists("images/uploads/Thumbnail-{$gambarlama}")) 
            {
                File::delete("images/uploads/Thumbnail-{$gambarlama}");
            }
            $modelProducts->image = $helperuntukupload;
        }    

        $generateqrcodelama = $modelProducts->qr_code; // value lama
        $modelProducts->qr_code = $generateqrcodelama; // value baru
        // $modelProducts->qr_code = $request->qr_code; // coba

        $urlcodelama = $modelProducts->url_qr_code; // value lama
        $modelProducts->url_qr_code = $urlcodelama; // value baru
        // $modelProducts->qr_code = $request->url_qr_code; // coba

        if($modelProducts->save())
        {
            // HISTORY PRODUCTS
            $modelHistoryProducts = new HistoryProducts();
            $modelHistoryProducts->kode_products_id = $kodelama; 
            $modelHistoryProducts->nama = $namalama;
            $modelHistoryProducts->deskripsi = $deskripsilama;
            $modelHistoryProducts->created_at = date('Y-m-d H:i:s');
            $modelHistoryProducts->created_by = $created_by_lama;
            $modelHistoryProducts->qr_code = $generateqrcodelama;
            $modelHistoryProducts->url_qr_code = $urlcodelama;
            $modelHistoryProducts->save();
            return response()->json(['data' => ['success'], 'status' => '200'], 200);
        }  else {
            return response()->json(['data' => ['false'], 'status' => '200'], 200);
        }               
    }

    public function apiGetDataById($id)
    {
        $this->access = Helpers::checkaccess('products', 'view');	

        if(!$this->access) return response()->json(['data' => [], 'status' => '401'], 200);   

        $datas = Product::with('brands', 'suppliers', 'categories', 'updatedby:id,name', 'createdby:id,name')->where('id', $id)->get();

        return response()->json(['data' => $datas, 'status' => '200'], 200);
    }
    
    public function apiDeleteProductsById($id, Request $request)
    {
        $this->access = Helpers::checkaccess('products', 'delete');
        if(!$this->access) return response()->json(['data' => ['false'], 'status' => '401'], 200);
        
        $datas = Product::where('id', $id)->first();

        $recordhistory = new HistoryProductsDelete;
        $recordhistory->nama = $datas->nama;
        $recordhistory->barcode = $datas->barcode;
        $recordhistory->satuan_id = $datas->satuan_id;
        $recordhistory->slug = $datas->slug;
        $recordhistory->active = $datas->active;
        $recordhistory->qr_code = $datas->qr_code;
        $recordhistory->url_qr_code = $datas->url_qr_code;
        $recordhistory->deskripsi = $datas->deskripsi;
        $recordhistory->image = $datas->image;
        $recordhistory->spesifikasi = $datas->spesifikasi;
        $recordhistory->supplier_id = $datas->supplier_id;
        $recordhistory->brand_id = $datas->brand_id;
        $recordhistory->category_id = $datas->category_id;
        $recordhistory->kode_products = $datas->kode_products;
        $recordhistory->history_created_at = $datas->created_at;
        $recordhistory->history_updated_at = $datas->updated_at;
        $recordhistory->history_updated_by = $datas->updated_by;
        $recordhistory->history_created_by = $datas->created_by;
        // 
        $recordhistory->delete_at = date('Y-m-d H:i:s');
        $recordhistory->delete_by = Auth::user()->id;
        $recordhistory->history_alasan_delete = $request->alasan_delete;

        if($recordhistory->save()) $datas->delete();        
        echo 'success';
    }

}
