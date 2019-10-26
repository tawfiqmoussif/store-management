<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Serie as SerieResource;
use App\Http\Resources\User as UserResource;
class Commande extends JsonResource
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
            'etat' => $this->etat,
            'prix' => $this->prix,
            'date' => $this->date,
            'clientO' => new UserResource($this->clientO()),
            'fournisseurO' => new UserResource($this->fournisseurO()),
            'serie' => new SerieResource($this->serie),
            'articles' => $this->articles,
        ];
    }
}
