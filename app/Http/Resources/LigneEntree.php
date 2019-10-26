<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LigneEntree extends JsonResource
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
            'entree_id' => $this->entree_id,
            'entree' => $this->entree,
            'serie_id' => $this->serie_id,
            'prix_unitaire' => $this->prix_unitaire,
            'prix_de_vente' => $this->prix_de_vente,
            'qte' => $this->qte,
            'serie' => $this->serie
        ];
    }
}
