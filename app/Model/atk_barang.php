<?php


namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class atk_barang extends Model
{
    protected $fillable = ['id_barang','nm_barang','id_satuan','harga','min_ga','max_ga','min_cab','max_cab','foto'];
    protected $primaryKey = 'id_barang';

    public function satuan()
    {
        return $this->belongsTo('App\Model\atk_satuan', 'id_satuan','id_satuan');
    }

    public function gudang()
    {
        return $this->hasMany('App\Model\atk_gudang', 'id_barang','id_barang');
    }
}

