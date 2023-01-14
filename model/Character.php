<?php

use \Illuminate\Database\Eloquent\Model;

class Character extends Model {
  public $timestamps = false;
  // protected $table ="characters";

  public function user(){
      return $this->belongsTo(User::class);
  }

  public static function validate($data){
    $errors=[];
    if(empty($data['color'])){
      $errors['color'] = 'Please select a color';
    }
    if(empty($data['name'])){
      $errors['name'] = 'Please give your character a name';
    }
    if(empty($data['user_id'])){
      $errors['user_id'] = 'something went wrong in the sign up process (no userId)';
    }
    if(empty($data['body'])){
      $errors['characterBody'] = 'No body was selected';
    }
    if(empty($data['head'])){
      $errors['characterHead'] = 'No head was selected';
    }
    return $errors;
  }
}
?>