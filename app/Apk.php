<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apk extends Model
{
    protected $fillable = ['filename', 'version', 'path', 'size'];

    public function games()
    {
        return $this->belongsToMany('App\Game');
    }
}
