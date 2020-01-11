<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    public function groups()
    {
        return $this->belongsToMany('App\Group');
    }
}
