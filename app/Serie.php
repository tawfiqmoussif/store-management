<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    public function magasin()
    {
        return $this->belongsTo('App\Magasin');

    }

    public function typeSerie()
    {
        return $this->belongsTo('App\TypeSerie');

    }
    public function fournisseur()
    {
        return $this->belongsTo('App\Fournisseur');
    }
    public function articles()
    {
        return $this->hasMany('App\Article');
    }
}
