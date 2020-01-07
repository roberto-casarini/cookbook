<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Ingredient extends JsonResource
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
            'data' => [
                'type' => 'ingredients',
                'id' => $this->id,
                'attributes' => [
                    'idFood' => $this->idFood,
                    'preparation' => $this->preparation,
                    'name' => $this->name,
                    'notes' => $this->notes, 
                    'quantity' => $this->quantity,
                ],
            ],
            'link' => [
                'self' => url('/recipes')
            ]
        ];
    }
}
