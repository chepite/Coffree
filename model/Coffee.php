<?php

use \Illuminate\Database\Eloquent\Model;

class Coffee extends Model {
  public $timestamps = true;
  protected $table= 'coffees';
  protected $primaryKey = 'user_id';
  //og code user
  public function user(){
    return $this->belongsTo(User::class);
  }
  public static function validate($data){
    $errors= [];
    if(empty($data['user_id'])){
      $errors['user_id'] = 'user_id fault';
    }
    if(empty($data['currentAmount'])){
      $errors['currentAmount'] = 'currentAmount fault';
    }
    if(empty($data['succesfull'])){
      $errors['succesfull'] = 'succesfull fault';
    }

    return $errors;
  }
}
?>