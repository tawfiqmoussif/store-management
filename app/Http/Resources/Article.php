<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Serie as SerieResource;

class Article extends JsonResource
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
            'serie_id' => $this->serie_id,
            'taille' => $this->taille,
            'stock' => $this->stock,
            'serie' => new SerieResource($this->serie)
        ];
    }
}
