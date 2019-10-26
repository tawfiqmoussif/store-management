<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Article as ArticleResource;

class SortieDetails extends JsonResource
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
            'prix_de_vente_1' => $this->prix_de_vente_1,
            'prix_de_vente_2' => $this->prix_de_vente_2,
            'nombre' => $this->nombre,
            'date' => $this->date,
            'article' => new ArticleResource($this->article)
        ];
    }
}
