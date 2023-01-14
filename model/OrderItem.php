<?php

use \Illuminate\Database\Eloquent\Model;

class OrderItem extends Model {

  public function order() {
    return $this->belongsTo(Order::class);
  }

  public function product() {
    return $this->belongsTo(Product::class);
  }

  public static function validate($data) {
    // https://www.php.net/manual/en/filter.examples.validation.php
    // https://www.php.net/manual/en/filter.filters.validate.php
    $errors = [];
    if (!isset($data['product_id']) || !filter_var($data['movie_id'], FILTER_VALIDATE_INT)) {
      $errors['movie_id'] = 'Please select a movie';
    }
    if (!isset($data['order_id']) || !filter_var($data['order_id'], FILTER_VALIDATE_INT)) {
      $errors['order_id'] = 'Please select an order';
    }
    if (!isset($data['amount']) || !filter_var($data['amount'], FILTER_VALIDATE_INT)) {
      $errors['amount'] = 'Please specify a amount';
    }
    return $errors;
  }
}
