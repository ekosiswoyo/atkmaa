<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class atk_pemakaian extends Model
{
    protected $fillable = ['id_pemakaian','id_gudang_brg','jml_pemakaian','harga_pemakaian','ket_pemakaian','bln_pemakaian'];
    protected $primaryKey = 'id_pemakaian';
}
