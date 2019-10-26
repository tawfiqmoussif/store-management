<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employe extends Model
{
    public function personne()
    {
        return $this->belongsTo('App\Personne');
    }
}
