<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'name', 'description','current_version',
    ];

    public function exercises()
    {
        return $this->belongsToMany('App\Exercise');
    }
}
