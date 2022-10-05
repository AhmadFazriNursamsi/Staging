<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable; // tambahan



use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $table = "products";
    public $timestamps = false;


    protected $fillable = [
        'nama'
    ];

    // Laravel Document : https://laravel.com/docs/8.x/routing#route-model-binding
    public function getRouteKeyName()
    {
        return 'slug';
        // return 'id';
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'nama'
            ]
        ];
    }

    public function suppliers()
    {
        return $this->hasMany('App\Models\Supplier', 'id', 'supplier_id');
    }

    public function brands()
    {
        return $this->hasMany('App\Models\Brand', 'id', 'brand_id');
    }

    public function categories()
    {
        return $this->hasMany('App\Models\Category', 'id', 'category_id');
    }

    public function historyproducts()
    {
        return $this->hasMany('App\Models\HistoryProducts','id', 'kode_products_id');
    }

    public function satuans()
    {
        return $this->hasMany('App\Models\Satuan', 'id', 'satuan_id');
    }

    public function gudangs()
    {
        return $this->hasMany('App\Models\Gudang','id', 'gudang_id');
    }

    public function list_products()
    {
        return $this->hasMany('App\Models\ListProduct','id', 'id_gudang');
    }

    public function updatedby()
    {
        return $this->hasOne('App\Models\User','id', 'updated_by');
    }

    public function createdby()
    {
        return $this->hasOne('App\Models\User','id', 'created_by');
    }
    
}


