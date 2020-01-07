<?php

namespace App;

use App\Food;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    public function preparationImages()
    {
        return $this->hasMany(PreparationImage::class, 'idRecipe');
    }

    public function ingredients()
    {
        return $this->belongsToMany(Food::class, 'ingredients', 'idRecipe', 'idFood')
            ->withPivot('id', 'preparation', 'notes', 'quantity');
    }
}
