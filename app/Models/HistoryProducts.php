<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryProducts extends Model
{
    use HasFactory;
    protected $table = "historyproducts";
    public $timestamps = false;


}
