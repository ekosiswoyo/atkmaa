<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nip','name','kelamin','agama','no_ktp','no_hp','role','id_jabatan','id_bagian','id_cabang','tgl_lahir','alamat','tgl_masuk','status_karyawan','email','status_user','avatar','password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function pics()
    {
      return $this->belongsTo('App\Models\atk_pics', 'id_pics','id_pics');
    }

    public function jabatan()
    {
      return $this->belongsTo('App\Models\Jabatan', 'id_jabatan','id_jabatan');
    }

    public function bagian()
    {
      return $this->belongsTo('App\Models\Bagian', 'id_bagian','id_bagian');
    }
}
