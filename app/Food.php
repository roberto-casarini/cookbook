<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    public function ingredients()
    {
        return $this->belongsToMany(Recipe::class, 'ingredients', 'idFood', 'idRecipe');
    }    
}
