<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{
    public function personne()
    {
        return $this->belongsTo('App\Personne');
    }
    public function series()
    {
        return $this->hasMany('App\Serie');
    }
}
