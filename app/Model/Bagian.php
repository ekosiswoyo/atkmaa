<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bagian extends Model
{
    protected $fillable = ['nama_bagian'];

    public function user()
    {
      return $this->hasMany('App\User', 'id_bagian','id');
    }
    
    public function laporan_mis_cabang()
    {
      return $this->hasMany('App\Models\LaporanMisCabang', 'id_cabang','id');
    }
    
    public function cabang()
    {
      return $this->belongstoMany('App\Models\Cabang', 'users','id_bagian','id_cabang')->withTimeStamps()
                  ->withPivot('nip','nama','kelamin','agama','no_ktp','no_hp','role','id_jabatan','tgl_lahir','alamat','tgl_masuk','status_karyawan','email','status_user','avatar');;
    }
    
    public function jabatan()
    {
      return $this->belongstoMany('App\Models\Jabatan', 'users','id_bagian','id_jabatan')->withTimeStamps()
                  ->withPivot('nip','nama','kelamin','agama','no_ktp','no_hp','role','id_cabang','tgl_lahir','alamat','tgl_masuk','status_karyawan','email','status_user','avatar');;
    }
    
    }