<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FOURNISSEUR extends JsonResource
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
            'id_fiscale' => $this->id_fiscale,
            'nom_marque' => $this->nom_marque,
            'personne' => $this->personne,
            'series' => $this->series
        ];
    }
}
