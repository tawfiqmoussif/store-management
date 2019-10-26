<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AvanceEntree extends Model
{
   
    public function entree()
    {
        return $this->belongsTo('App\Entree');
    }
}
