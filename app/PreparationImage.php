<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PreparationImage extends Model
{
    protected $fillable = ['url'];
        
    public function recipe()
    {
        $this->belongsTo(Recipe::class, 'idRecipe');
    }
}
