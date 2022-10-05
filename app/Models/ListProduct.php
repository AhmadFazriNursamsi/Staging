<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListProduct extends Model
{
    use HasFactory;
    protected $table = "list_product";

    public function gudangs()
    {
        return $this->hasMany('App\Models\Gudang','id', 'id_gudang');
    }
    public function products()
    {
        return $this->hasMany('App\Models\Product','id', 'id_product');
    }

}
