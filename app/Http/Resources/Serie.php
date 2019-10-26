<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Serie extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'ref' => $this->ref,
            'typeSerie' => $this->typeSerie,
            'type_serie_id' => $this->type_serie_id,
            'couleur' => $this->couleur,
            'photo' => $this->photo,
            'genre' => $this->genre,
            'fournisseur' => $this->fournisseur,
            'fournisseur_id' => $this->fournisseur_id,
            'personne' => $this->fournisseur->personne,
            'series' => $this->fournisseur->series,
            'articles' => $this->articles
        ];
    }
}
