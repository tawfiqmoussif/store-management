<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entree extends Model
{
    public function fournisseur()
    {
        return $this->belongsTo('App\Fournisseur');
    }
    public function lignes()
    {
        return $this->hasMany('App\LigneEntree');
    }
    public function avances()
    {
        return $this->hasMany('App\AvanceEntree');
    }
 
}
