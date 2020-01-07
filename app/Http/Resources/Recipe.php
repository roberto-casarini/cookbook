<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Recipe extends JsonResource
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
                'type' => 'recipes',
                'id' => $this->id,
                'attributes' => [
                    'presentation' => [
                        'description' => $this->presentationDescription,
                        'photo' => $this->presentationPhoto,
                    ],
                    'ingredients' => new IngredientCollection($this->ingredients),
                    'preparation' => [
                        'title' => $this->preparationTitle,
                        'text' => $this->preparationText,
                        'images' => new PreparationImageCollection($this->preparationImages),
                    ],
                    'conservation' => $this->conservation,
                ],
                'links' => [
                    'self' => url('/recipes/' . $this->id)
                ]
            ]
        ];
    }
}
