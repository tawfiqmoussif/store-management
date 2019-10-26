<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Sortie as SortieResource;

class AvanceSortie extends JsonResource
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
            'type_paiement' => $this->type_paiement,
            'date' => $this->date,
            'description' => $this->description,
            'montant' => $this->montant,
            'numero' => $this->numero,
            'sortie_id' => $this->sortie_id,
            'sortie' => new SortieResource($this->sortie),
        ];
    }
}