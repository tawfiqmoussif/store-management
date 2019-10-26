<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Charge extends JsonResource
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
            'montant_total' => $this->montant_total,
            'date' => $this->date,
            'typeCharge' => $this->typeCharge
        ];
    }
}
