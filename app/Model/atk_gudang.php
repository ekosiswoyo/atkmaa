<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class atk_gudang extends Model
{


    protected $fillable = ['id_gudang_brg','id_barang','pic','jml'];
    protected $primaryKey = 'id_gudang_brg';

    public function barang()
    {
        return $this->belongsTo('App\Model\atk_barang', 'id_barang','id_barang');
    }
}
