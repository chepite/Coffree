<?php

use \Illuminate\Database\Eloquent\Model;

class Order extends Model {

  public function orderItems() {
    return $this->hasMany(OrderItem::class);
  }

  public static function validate($data) {
    $errors = [];
    if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
      $errors['email'] = 'Please fill in a valid email address';
    }
    return $errors;
  }
}
