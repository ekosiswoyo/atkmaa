<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class atk_tambah extends Model
{
    protected $fillable = ['id_atk_tambah','id_gudang_brg','id_barang','jml_beli','harga_beli','bulan_beli','pic_beli'];
    protected $primaryKey = 'id_atk_tambah';
}
