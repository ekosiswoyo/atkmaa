<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class atk_awal extends Model
{
    protected $fillable = ['id_atk_awal','id_gudang_brg','id_barang','pic','jml','harga','bulan'];
    protected $primaryKey = 'id_atk_awal';
}
