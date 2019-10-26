<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AvanceSortie extends Model
{
    public function sortie()
    {
        return $this->belongsTo('App\Sortie');
    }
}
