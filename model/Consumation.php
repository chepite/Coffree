<?php

use \Illuminate\Database\Eloquent\Model;

class Consumation extends Model {
  public $timestamps = false;
  public function users(){
    return $this->belongsTo(User::class);
  }
  public function recipe(){
    return $this->belongsTo(Recipe::class);
  }

  public static function validate($data){
      $errors = [];
      if(empty($data['user_id'])){
        $errors['user_id'] = "no user_id";
      }
      if(empty($data['recipe_id'])){
        $errors['recipe_id'] = "no recipe_id";
      }
      return $errors;
  }
}
?>