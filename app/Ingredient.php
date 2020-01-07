<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $fillable = ['idFood', 'idRecipe', 'preparation', 'notes', 'quantity'];

    public function recipe()
    {
        $this->belongsTo(Recipe::class, 'idRecipe');
    }
}
