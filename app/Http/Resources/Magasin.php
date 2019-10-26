<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Magasin extends JsonResource
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
            'nom' => $this->nom,
            'numero_de_patente'=>$this->numero_de_patente,
            'rc' => $this->rc,
            'numero_compte_bancaire'=>$this->numero_compte_bancaire,
            'user' => $this->user
        ];
    }
}
