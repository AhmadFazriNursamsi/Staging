<?php

namespace App\Http\Controllers;

// model
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
// model

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\HelpersController as Helpers;

class PurchaseOrdersController extends Controller
{
    public function index()
    {      

        $this->access = Helpers::checkaccess('purchaseorders', 'view');
        if(!$this->access) {
            Session::flash('message', "you don't have permission to access");
            return redirect('/dashboard');  
        }
        $products = Product::get();
        
        return view('purchaseorders.index', array(
            'products' => $products,
            'purchase_order' => PurchaseOrder::all(),
        ));        
    }   

    public function apiGetData() // tampil di depan halam success
    {
        $purchaseorders = PurchaseOrder::with('detailPreOrder')->get();
        // dd($purchaseorders);

        $datas = [];
        $i = 1;
        foreach($purchaseorders as $key => $preOrder)
        {
            $datas[$key] = [                   
                $i++,
                $preOrder->no_purchase_order,
                $preOrder->detailPreOrder[0]->jumlah_produk,  
                '',  
                '',  
                $preOrder->deskripsi_po, 
                $preOrder->id,
                $preOrder->flag_delete,
            ];
        }
        return response()->json(['data' => $datas, 'status' => '200'], 200);
    }

    public function apiSearch(Request $request)
    {
        $p = $request->get('query');
        $data = Product::select("nama", "id", "image")
                ->where('nama','LIKE',"%{$p}%")
                ->get();

        return response()->json($data);
    }

    
    public function apiGetDataId($id)
    {
        $products = Product::where('id', $id)->get();

        $datas = [];
        $i = 1;
        foreach($products as $key => $product)
        {
            $datas[$key] = [
                $i++, 
                $product->nama,
                $product->satuan,
                '',
                '',
                '',
                $product->id
            ];
        }
            
        return response()->json(['data' => $datas, 'status' => '200'], 200);    
    }

    public function apiDetailById($id)
    {
        $details = PurchaseOrder::with('detailPreOrder', 'detailPreOrder.products')->where('id', $id)->first(); // Table View Details success
        // dd($details);
        $vDetailData = [];
        $i = 1; 

        foreach($details->detailPreOrder as $key => $value) 
        {

            $vDetailData[$key] = 
            [
                $i++, 
                $details->detailPreOrder[$key]->products->nama, 
                $value->jumlah_produk,
                $value->barang_bagus, 
                $value->barang_jelek, 
                $details->id,
                $details->no_purchase_order,
                $details->deskripsi_po,
                $details->detailPreOrder[$key]->products->id,
            ]; 
        }
        return response()->json(['data' => $vDetailData, 'status' => '200'], 200);
    }

    public function apiInsertData(Request $request)
    {
        $this->access = Helpers::checkaccess('purchaseorders', 'add');
        if(!$this->access) return response()->json(['data' => ['false'], 'status' => '401'], 200);

        $validator = Validator::make($request->all(), [
            'no_purchase_order' => 'required|min:4|unique:purchase_order',
        ], [
            'no_purchase_order.required' => 'No Purchase Order Harus Di Isi',
            'no_purchase_order.unique' => 'No Purchase Order Tidak Boleh Sama',
            'products_id.required' => 'Produk Harus Di Isi',
            'deskripsi_po.required' => 'Deskripsi Harus Di Isi',
        ]); 

        if ($validator->fails()) {
            return response()->json(['errors'=> $validator->errors()->all()]);
        }

        $datas = new PurchaseOrder;
        $datas->no_purchase_order = $request->no_purchase_order;
        $datas->deskripsi_po = $request->deskripsi_po;
        $datas->created_at = date('Y-m-d H:i:s');
        $datas->updated_at = date('Y-m-d H:i:s');
        $datas->created_by = Auth::user()->id; 
        $datas->updated_by = Auth::user()->id;
        

        if($datas->save())
        {
            if($request->user_group != '')
            {
                $explode = explode(", ", $request->user_group);
                foreach ($explode as $explode_id) {
                    if($explode_id == '') continue;
                    $cariProduk = PurchaseOrderDetail::where('purchases_order_id', $datas->id)->where('products_id', $explode_id)->first(); // cek apakah pernah di input
                    if(isset($cariProduk->id)) continue;
    
                    $detailPurchaseOrder = new PurchaseOrderDetail;
                    $detailPurchaseOrder->purchases_order_id = $datas->id;
                    $detailPurchaseOrder->products_id = $explode_id;
                    $detailPurchaseOrder->jumlah_produk = $request->jumlah_produk["'id'"][$explode_id];
                    $detailPurchaseOrder->barang_bagus = 0;
                    $detailPurchaseOrder->barang_jelek = 0;
                    $detailPurchaseOrder->created_at = date('Y-m-d H:i:s');
                    $detailPurchaseOrder->updated_at = date('Y-m-d H:i:s');
                    $detailPurchaseOrder->save();                   
                }
            }
        }
        
        return response()->json(['data' => ['success'], 'status' => '200'], 200);
    }

     function apiInsertDataKarantina(Request $request)
    {
        dd($request);
        
        $this->access = Helpers::checkaccess('purchaseorders', 'add');
        if(!$this->access) return response()->json(['data' => ['false'], 'status' => '401'], 200);

        $validator = Validator::make($request->all(), [
            'no_purchase_order' => 'required|min:4|unique:purchase_order',
        ], [
            'no_purchase_order.required' => 'No Purchase Order Harus Di Isi',
            'no_purchase_order.unique' => 'No Purchase Order Tidak Boleh Sama',
            'products_id.required' => 'Produk Harus Di Isi',
            'deskripsi_po.required' => 'Deskripsi Harus Di Isi',
        ]); 

        if ($validator->fails()) {
            return response()->json(['errors'=> $validator->errors()->all()]);
        }

        $datas = new PurchaseOrder;
        $datas->no_purchase_order = $request->no_purchase_order;
        $datas->deskripsi_po = $request->deskripsi_po;
        $datas->flag_delete = 1;
        $datas->created_at = date('Y-m-d H:i:s');
        $datas->updated_at = date('Y-m-d H:i:s');
        $datas->created_by = Auth::user()->id; 
        $datas->updated_by = Auth::user()->id;
        

        if($datas->save())
        {
            if($request->user_group != '')
            {
                $explode = explode(", ", $request->user_group);
                foreach ($explode as $explode_id) {
                    if($explode_id == '') continue;
                    $cariProduk = PurchaseOrderDetail::where('purchases_order_id', $datas->id)->where('products_id', $explode_id)->first(); // cek apakah pernah di input
                    if(isset($cariProduk->id)) continue;
    
                    $detailPurchaseOrder = new PurchaseOrderDetail;
                    $detailPurchaseOrder->purchases_order_id = $datas->id;
                    $detailPurchaseOrder->products_id = $explode_id;
                    $detailPurchaseOrder->jumlah_produk = $request->jumlah_produk["'id'"][$explode_id];
                    $detailPurchaseOrder->barang_bagus = 0;
                    $detailPurchaseOrder->barang_jelek = 0;
                    $detailPurchaseOrder->created_at = date('Y-m-d H:i:s');
                    $detailPurchaseOrder->updated_at = date('Y-m-d H:i:s');
                    $detailPurchaseOrder->save();                   
                }
            }
        }
        
        return response()->json(['data' => ['success'], 'status' => '200'], 200);
    }

    public function apiUpdateDataById($id, Request $request)
    {   
        $updatePreOrder = PurchaseOrder::where('no_purchase_order', $request->no_purchase_order)->first();
        if (isset($updatePreOrder->id) && $updatePreOrder->id != $id) 
        {
            return response()->json(['errors' => [false, 'No Purchase Order sudah ada'], 'status' => '401'], 200);
        }

        $updatePreOrder = PurchaseOrder::where('id', $id)->first();
        $updatePreOrder->no_purchase_order = $request->no_purchase_order;
        $updatePreOrder->deskripsi_po = $request->deskripsi_po;
        $updatePreOrder->updated_at = date('Y-m-d H:i:s');
        $updatePreOrder->created_by = Auth::user()->id; 
        $updatePreOrder->updated_by = Auth::user()->id;

        if($updatePreOrder->save())
        {
            if($request->user_group != '')
            {                          
                $explode = explode(', ', $request->user_group);
                PurchaseOrderDetail::where('purchases_order_id', $id)->delete(); // cek 

                foreach($explode as $explode_id)
                {
                    if($explode_id == '') continue;
                    $VPurchaseOrder = new PurchaseOrderDetail;
                    $VPurchaseOrder->purchases_order_id = $id;
                    $VPurchaseOrder->products_id = $explode_id;
                    $VPurchaseOrder->jumlah_produk =  $request->jumlah_produk["'id'"][$explode_id];
                    $VPurchaseOrder->barang_bagus = $request->barang_bagus["'id'"][$explode_id];
                    $VPurchaseOrder->barang_jelek = $request->barang_jelek["'id'"][$explode_id];
                    $VPurchaseOrder->updated_at = date('Y-m-d H:i:s');
                    $VPurchaseOrder->save(); 
                }
            }
        }
        return response()->json(['data' => ['success'], 'status' => '200'], 200);
    }  

    public function apiDeleteDataById($id, Request $request)
    {
        $deletePurchaseOrder = PurchaseOrder::where('id', $id)->first();
        
        $deletePurchaseOrder->flag_delete = 1;
        if(isset($request->undeleted)) $deletePurchaseOrder->flag_delete = 0;
        $deletePurchaseOrder->save();


        return response()->json(['data' => ['success'], 'status' => '200'], 200);

    }
}
