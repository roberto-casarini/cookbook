<?php

namespace App\Repositories;

use App\Recipe;
use App\Ingredient;
use DB;

class RecipeRepository 
{
    public function newRecipe($data)
    {
        $fields = $data['data']['attributes'];
        $recipe = new Recipe();
        DB::transaction(function () use ($recipe, $fields) {
            $recipe->idUser = auth()->user()->id;
            $recipe->title = $fields['title'];
            $recipe->preparationTitle = $fields['preparation']['title'];        
            $recipe->preparationText = $fields['preparation']['text'];
            $recipe->presentationPhoto = $fields['presentation']['photo'];
            $recipe->presentationDescription = $fields['presentation']['description'];
            $recipe->conservation = $fields['conservation'];
            $recipe->save();
            $recipe->refresh();
                
            $this->addPreparationImages($recipe, $fields['preparation']['images']);
            $this->addIngredients($recipe, $fields['ingredients']);
        });
        return $recipe;
    }

    private function addPreparationImages($recipe, $photos)
    {
        foreach($photos as $photo) {
            $recipe->preparationImages()->create($photo);
        }
    }

    private function addIngredients($recipe, $ingredients)
    {
        foreach($ingredients as $ingredient) {
            $recipe->ingredients()->attach($recipe->id, [
                "idFood" => $ingredient["idFood"],
                "preparation" => $ingredient["preparation"],
                "notes" => $ingredient["notes"],
                "quantity" => $ingredient["quantity"],
            ]);
        }
    }
}