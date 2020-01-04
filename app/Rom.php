<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rom extends Model
{
    public function joints()
    {
        return $this->belongsToMany('App\Joint');
    }
}
