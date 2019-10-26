<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Serie as SerieResource;
class LigneSortie extends JsonResource
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
            'id_sortie' => $this->sortie_id,
            'qte' => $this->qte,
            'sortie' => $this->sortie,
            'prix_unitaire' => $this->prix_unitaire,
            'serie' => $this->serie

        ];
    }
}
