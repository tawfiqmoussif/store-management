<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LigneSortie extends Model
{ 
    public function sortie()
    {
        return $this->belongsTo('App\Sortie');
    }
    public function serie()
    {
        return $this->belongsTo('App\Serie');
    }
}
