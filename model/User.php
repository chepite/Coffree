<?php

use \Illuminate\Database\Eloquent\Model;

class User extends Model {
  public $timestamps = true;
    // protected $table ="users";
  public function character(){
      return $this->hasOne(Character::class);
  }
  //og code coffee
  // public function coffee(){
  //     return $this->hasMany(Coffee::class);
  // }
  public function coffees(){
    return $this->hasOne(Coffee::class);
}
  public function consumation(){
      return $this->belongsToMany(Consumation::class);
  }

  //test code
  //many to many relationships without giving eloquent the name of the intermediate table
  public function trophies(){
    return $this->belongsToMany(Trophy::class);
  }
 /* public function detox(){
    return $this->belongsToMany(Detox::class);
  }*/
  public function recipes(){
    return $this->belongsToMany(Recipe::class);
  }
  public function ingredients(){
    return $this->belongsToMany(Ingredient::class);
  }
  //test recipe button
  public function consumations(){
    return $this->hasMany(Consumation::class);
  }
  //end test recipe button

  public static function validatesignup($data){
    $errors = [];

    if(empty($data['username'])){
      $errors['username'] = 'Please fill in a username';
    }
    if(strlen($data['username'])>=32){
      $errors['tooLong'] = 'Username too long, max 32 characters';
    }
    if(empty($data['password'])){
      $errors['password'] = 'Please fill in an password';
    }
    if(strlen($data['password']) < 8){
      $errors['passwordLength']= 'Password should more than 8 characters long';
    }
    if(empty($data['repeatPassword'])){
      $errors['repeatPassword'] = 'please repeat the password';
    }
    if($data['password'] != $data['repeatPassword']){
      $errors['password mismatch'] = 'please repeat the password correctly to resume';
    }
    return $errors;
  }

  public static function validateCharacterName($data){
    $errors= [];
    if(empty($data['characterName'])){
      $errors['character name']= 'please fill in a name for your character';
    }
    if(strlen($data['characterName'])>32){
      $errors['characterTooLong']= 'characterName too long, max. 32 characters';
    }
    return $errors;
  }

  public static function validateCharacterGenerator(){
    
  }

  /*if(empty($data['characterName'])){
      $errors['characterName'] = 'Please fill in a character name';
    }
    if(empty($data['characterColor'])){
      $errors['characterColor'] = 'Please select a color';
    }
    if(empty($data['characterHead'])){
      $errors['characterHead'] = 'Please select a head';
    }
    if(empty($data['characterBody'])){
      $errors['characterBody'] = 'Please select a body';
    }*/

  


  
}
?>