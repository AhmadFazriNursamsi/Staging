<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryProductsDelete extends Model
{
    use HasFactory;
    protected $table = "historydeleteproducts";
    public $timestamps = false;

}
