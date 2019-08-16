<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    protected $fillable = ['id','nama'];

  public function report_kacab()
  {
    return $this->hasMany('App\Models\ReportKacab','id_cabang', 'id'); //'id_cabang','id'   == 'foreign key di tabel report_kacabs','primaryKey di tabel cabangs'
  }

  public function user()
  {
    return $this->hasMany('App\User', 'id_cabang','id');
  }

  public function laporan_mis_cabang()
  {
    return $this->hasMany('App\Models\LaporanMisCabang', 'id_cabang','id');
  }

  public function jabatan()
  {
    return $this->belongstoMany('App\Models\Jabatan', 'users', 'id_cabang', 'id_jabatan')->withTimeStamps()
                ->withPivot('nip','nama','kelamin','agama','no_ktp','no_hp','role','id_bagian','tgl_lahir','alamat','tgl_masuk','status_karyawan','email','status_user','avatar');
  }

  public function bagian()
  {
    return $this->belongstoMany('App\Models\Bagian', 'users', 'id_cabang', 'id_bagian', 'id_jabatan')->withTimeStamps()
                ->withPivot('nip','nama','kelamin','agama','no_ktp','no_hp','role','id_jabatan','tgl_lahir','alamat','tgl_masuk','status_karyawan','email','status_user','avatar');;
  }

}
