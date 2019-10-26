<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sortie extends Model
{
    public function client()
    {
        return $this->belongsTo('App\Client');
    }
    public function lignes()
    {
        return $this->hasMany('App\LigneSortie');
    }
    public function avances()
    {
        return $this->hasMany('App\AvanceSortie');
    }
}
