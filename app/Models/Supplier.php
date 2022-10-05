<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $table = "suppliers";

    protected $fillable = [
        'supplier_name', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];

    public function updatedby()
    {
        return $this->hasOne('App\Models\User','id', 'updated_by');
    }

    public function createdby()
    {
        return $this->hasOne('App\Models\User','id', 'created_by');
    }
}
