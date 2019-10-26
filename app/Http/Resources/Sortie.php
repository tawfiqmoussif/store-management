<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\LigneSortie as LigneSortieResource;

class Sortie extends JsonResource
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
            'client' => $this->client,
            'personne' => $this->client->personne,
            'montant_total' => $this->montant_total,
            'montant' => $this->montant,
            'lignes' => LigneSortieResource::collection($this->lignes),
            'avances' => $this->avances,
            'date' => $this->date
        ];
    }
}
