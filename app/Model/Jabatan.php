<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $fillable = ['nama_jabatan'];

public function user()
{
  return $this->hasMany('App\User', 'id_jabatan','id');
}

public function bagian()
{
  return $this->belongstoMany('App\Models\Bagian', 'users', 'id_jabatan', 'id_bagian')->withTimeStamps()
              ->withPivot('nip','nama','kelamin','agama','no_ktp','no_hp','role','id_cabang','tgl_lahir','alamat','tgl_masuk','status_karyawan','email','status_user','avatar');;
}

public function cabang()
{
  return $this->belongstoMany('App\Models\Cabang', 'users','id_jabatan','id_cabang')->withTimeStamps()
              ->withPivot('nip','nama','kelamin','agama','no_ktp','no_hp','role','id_bagian','tgl_lahir','alamat','tgl_masuk','status_karyawan','email','status_user','avatar');;
}

}
