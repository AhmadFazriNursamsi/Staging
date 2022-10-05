<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderDetail extends Model
{
    use HasFactory;
    protected $table = "purchase_order_detail";

    public function products()
    {
        return $this->hasOne('App\Models\Product', 'id', 'products_id');
    }

    public function purchases_order()
    {
        return $this->hasMany('App\Models\PurchaseOrder','id', 'purchases_order_id');
    }

    public function jumlah_produk()
    {
        return $this->hasMany('App\Models\PurchaseOrder','id', 'jumlah_produk');

    }

}
