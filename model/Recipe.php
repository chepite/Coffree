<?php

use \Illuminate\Database\Eloquent\Model;

class Recipe extends Model {
  public $timestamps = false;

  //test code many to many
  public function users(){
    return $this->belongsToMany(User::class);
  }
  //test conumation api
  public function consumations(){
    return $this->belongsToMany(Consumation::class);
  }
  //test consumation api

  // public function ingredients(){
  //   return $this->belongsToMany(Ingredient::class);
  // }

  //end test code many to many
  //ogcode
  // public function brewery(){
  //   return $this->hasMany(Brewery::class);
  // }
  
  // public function recipeIngredient(){
  //     return $this->hasMany(RecipeIngredient::class);
  // }
  //end og code

}
?>