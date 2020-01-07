<?php

namespace App\Http\Controllers;

use App\Http\Resources\Recipe as RecipeResource;
use App\Http\Requests\RecipeRequest;
use App\Repositories\RecipeRepository;


class RecipeController extends Controller
{
    public function store(RecipeRequest $request, RecipeRepository $repo)
    {
        $request->validated();
        $recipe = $repo->newRecipe($request);
        return new RecipeResource($recipe);
    }
}
