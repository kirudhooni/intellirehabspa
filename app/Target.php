<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    protected $fillable = [
        'name', 'description',
    ];

    public function joints()
    {
        return $this->belongsToMany('App\Joint')->withPivot('rom_id','rom_value');
    }
    

    
}
