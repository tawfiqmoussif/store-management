<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\LigneEntree as LigneEntreeResource;


class Entree extends JsonResource
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
            'fournisseur' => $this->fournisseur,
            'lignes' => LigneEntreeResource::collection($this->lignes),
            'avances' => $this->avances,
            'personne' => $this->fournisseur->personne,
            'montant_total' => $this->montant_total,
            'montant_paye' => $this->montant_paye,
            'date' => $this->date
        ];
    }
}
