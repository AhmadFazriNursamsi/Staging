<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory; //

    protected $table = "purchase_order";
    public $timestamps = false;

    public function products()
    {
        return $this->hasMany('App\Models\Product', 'id', 'products_id');
    }

    public function detailPreOrder()
    {
        return $this->hasMany('App\Models\PurchaseOrderDetail','purchases_order_id', 'id');
    }



}

