<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    protected $fillable = [
        'name', 'description',
    ];

    public function joints()
    {
        return $this->belongsToMany('App\Joint');
    }
    public function games()
    {
        return $this->belongsToMany('App\Game');
    }
    public function limbs()
    {
        return $this->belongsToMany('App\Limb');
    }
}
