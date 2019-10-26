<?php

namespace App;
use App\User;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    public function serie()
    {
        return $this->belongsTo('App\Serie');
    }
    public function articles()
    {
        return $this->hasMany('App\ArticleCommande');
    }
    public function clientO()
    {
        return User::findOrFail($this->client);
    }
    public function fournisseurO()
    {
        return User::findOrFail($this->fournisseur);
    }
}
