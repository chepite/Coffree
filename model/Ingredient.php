<?php

use \Illuminate\Database\Eloquent\Model;

class Ingredient extends Model {
  public $timestamps = false;

  public function recipes(){
    return $this->belongsToMany(Recipe::class);
  }

  //og code
  // public function consumation(){
  //     return $this->belongsToMany(Consumation::class);
  // }

  // public function recipeIngredient(){
  //   return $this->belongsToMany(RecipeIngredient::class);
  // }
    //og code
}
?>