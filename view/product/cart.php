<link rel="stylesheet" href="css/cart.css">
<section>
  <h2>Checkout</h2>
  <form method="post" action="index.php?page=cart">
    <table class="cart-table">
      <thead>
        <tr>
          <th>Item</th>
          <th>Price</th>
          <th>Amount</th>
          <th></th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
      <?php $totalPrice= 0; ?>
      <?php foreach ($_SESSION['cart'] as $item){
        
         $itemTotal = $item["quantity"] * $item["product"]["price"];
         
         $totalPrice += $itemTotal;
      echo('  
        <tr>
          <td class="cart-table__item-image">'.'<img class="cart__image" src="assets/products/'.  $item['product']['image'].'.png"></td>
          
          <td class="cart-table__item-price">'. $item['product']["price"].'</td>
          <td class="cart-table__item-quantity"><input type="number" class="input-quantity" name="quantity['. $item['product']['id'].']" value="'. $item['quantity'].'" /></td>
          <td><button class="btn" type="submit" name="remove" value="'. $item['product']['id'].'">Remove</button></td>
          <td class="cart-table__item-price">'.($item['product']["price"] * $item['quantity']).'</td>
        </tr>');
      }
        ?>

      </tbody>
      <tfoot>
        <tr>
          <th colspan="3" class="cart-table__offset-left"></th>
          <th class="cart-table__item-quantity">Total</th>
          <td class="cart-table__item-price finaltotal"><?php echo $totalPrice; ?></td>
        </tr>
      </tfoot>
    </table>
      <div class="cart__small">
    <div class="mb-4">
      <button class="btn updateCart" type="submit" name="action" value="update">Update Cart</button>
    </div>

    <div class="mb-2 email">
      <label for="email">E-mail adress</label>
        <input type="email" name="email" value="<?php if (!empty($_POST['email'])) echo $_POST['email']; ?>" />
        <span class="error"><?php if(!empty($errors['email'])){
          echo $errors['email'];}?></span>
      
    </div>

    <!-- <div class="mb-2">
      <label>
        <input type="checkbox" name="accepted_general_conditions" value="1" <?php if (!empty($_POST['accepted_general_conditions'])) echo 'checked'; ?> />
        I agree with the terms &amp; conditions
      </label>
    </div> -->

    <div class="mb-2">
      <button class="btn" type="submit" name="action" value="order">Place Order</button>
    </div>
    <div>
  </form>
</section>
<script src="js/validate.js"></script>

<?php 
  // if($errors){
  //   var_dump($errors);
  // }
?>