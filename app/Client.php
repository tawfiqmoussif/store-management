<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public function personne()
    {
        return $this->belongsTo('App\Personne');
    }
}
