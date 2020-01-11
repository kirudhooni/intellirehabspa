<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
class Group extends Model
{
    protected $fillable = [
        'name', 'description',
    ];

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function patients()
    {
        return $this->belongsToMany('App\Patient');
    }
}
