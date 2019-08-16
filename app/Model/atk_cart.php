<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class atk_cart extends Model
{
    protected $fillable = ['id_barang','jml','status','id_user'];
    protected $primaryKey = 'id_cart';
}
