<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = "categories";

    protected $fillable = [
        'category_name', 'created_at', 'updated_at', 'created_by', 'updated_by'
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
