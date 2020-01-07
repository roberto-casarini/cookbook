<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PreparationImage extends JsonResource
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
                'type' => 'preparationImage',
                'id' => $this->id,
                'attributes' => [
                    'url' => $this->url,
                ],
            ],
            'link' => [
                'self' => url('/recipes')
            ]
        ];
    }
}
