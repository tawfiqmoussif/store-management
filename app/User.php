<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function personne()
    {
        return $this->belongsTo('App\Personne');
    }
    public function magasin()
    {
        return $this->hasOne('App\Magasin');
    }
    public function employes()
    {
        return $this->hasMany('App\Employe');
    }
    public function etats()
    {
        return $this->hasMany('App\Etat');
    }
    public function avanceEmployes()
    {
        return $this->hasMany('App\EvanceEmploye');
    }
    public function charges()
    {
        return $this->hasMany('App\Charge');
    }
    public function clients()
    {
        return $this->hasMany('App\Client');
    }
    public function entrees()
    {
        return $this->hasMany('App\Entree');
    }
    public function fournisseurs()
    {
        return $this->hasMany('App\Fournisseur');
    }
    public function ligneEntrees()
    {
        return $this->hasMany('App\LigneEntree');
    }
    public function ligneSorties()
    {
        return $this->hasMany('App\LigneSortie');
    }
    public function series()
    {
        return $this->hasMany('App\Serie');
    }
    public function sorties()
    {
        return $this->hasMany('App\Sortie');
    }
    public function sortieDetails()
    {
        return $this->hasMany('App\SortieDetails');
    }
    public function typeCharges()
    {
        return $this->hasMany('App\TypeCharge');
    }
    public function typeSeries()
    {
        return $this->hasMany('App\TypeSerie');
    }
}
