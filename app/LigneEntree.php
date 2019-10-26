<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LigneEntree extends Model
{
    public function entree()
    {
        return $this->belongsTo('App\Entree');
    }
    public function serie()
    {
        return $this->belongsTo('App\Serie');
    }
}
