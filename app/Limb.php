<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Limb extends Model
{
    public function joints()
    {
        return $this->belongsToMany('App\Joint');
    }

    
}
