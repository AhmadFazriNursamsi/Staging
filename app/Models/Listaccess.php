<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listaccess extends Model
{
    use HasFactory;
    protected $table = "list_access";
    public $timestamps = false;
    protected $primaryKey = 'id_access';

    public function user_access()
    {
        return $this->hasMany('App\Models\Useraccess','id_access', 'id_access');
    }
    
}
