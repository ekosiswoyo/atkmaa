<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        'name', 'email', 'password','id_pics','last_login_at',
        'last_login_ip',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
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
