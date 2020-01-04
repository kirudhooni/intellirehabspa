<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Joint extends Model
{
    
    public function exercises()
    {
        return $this->belongsToMany('App\Exercise');
    }

    public function roms()
    {
        return $this->belongsToMany('App\Rom');
    }
}
