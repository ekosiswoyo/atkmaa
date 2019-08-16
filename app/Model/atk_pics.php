<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class atk_pics extends Model
{
    protected $fillable = ['id_pics','nm_pic'];


    public function user()
    {
        return $this->hasMany('App\User', 'id_pics','id_pics');
    }

}
