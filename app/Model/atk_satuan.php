<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class atk_satuan extends Model
{
    protected $fillable = ['id_satuan','nm_satuan'];
    protected $primaryKey = 'id_satuan';

    public function barang()
    {
        return $this->hasMany('App\Model\atk_barang', 'id_satuan','id_satuan');
    }
}
