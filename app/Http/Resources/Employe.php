<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Employe extends JsonResource
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
            'date_recrutement' => $this->date_recrutement,
            'salaire' => $this->salaire,
            'sommesalaires' => $this->sommesalaires,
            'personne' => $this->personne

        ];
    }
}
