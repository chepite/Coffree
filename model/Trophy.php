<?php

use \Illuminate\Database\Eloquent\Model;

class Trophy extends Model {
  public $timestamps = false;
  //test code
  public function user(){
         return $this->belongsToMany(User::class);
    }
  //test code
  //og code
  // public function userTrophy(){
  //     return $this->belongsToMany(userTrophy::class);
  // }
  //end og code
}
?>