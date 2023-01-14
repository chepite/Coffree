<link rel="stylesheet" href="css/cart.css">
<section>
    <h2>Order Confirmation</h2>
  <p>Order placed by <?php echo $order->email; ?> on <?php echo $order->created_at; ?></p>
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
      <?php foreach ($order->orderItems as $item){
        
         $itemTotal = $item["amount"] * $item["product"]["price"];
         
         $totalPrice += $itemTotal;
      echo('  
        <tr>
          <td class="cart-table__item-image">'.'<img class="cart__image" src="assets/products/'.  $item['product']['image'].'.png"></td>
          
          <td class="cart-table__item-price">'. $item['product']["price"].'</td>
          <td class="cart-table__item-quantity">'.  $item['amount'] .'</td>
          <td class="cart-table__item-price">'.($item['product']["price"] * $item['amount']).'</td>
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
    </section>