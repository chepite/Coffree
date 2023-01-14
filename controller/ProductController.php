<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../model/Product.php';
require_once __DIR__ . '/../model/Order.php';
require_once __DIR__ . '/../model/OrderItem.php';

class ProductController extends Controller{
    public function index(){
        $this->set('highlightedProducts', Product::limit(2)->get());
        $this->set('title','home');
    }

    public function shop(){
        if (!empty($_POST['action'])) {
            if ($_POST['action'] == 'addItem') {
              $this->_handleAdd();
              header('Location: index.php?page=shop');
              exit();
            }
          }
        $this->set('products', Product::get());
        $this->set('title', 'shop');
    }

    private function _handleAdd() {
        // when the movie isn't present in the cart: start with amount 0
        if (empty($_SESSION['cart'][$_POST['product_id']])) {
          $product = Product::find($_POST['product_id']);
          if (empty($product)) {
            // non existing movie? do an early return
            // this way we avoid executing un-necessary logic
            return;
          }
          // store the movie info and the amount in the session
          // notice: we can't store a model instance in a session, we need it as a "simple" associative array
          // the key will be the movie_id, which was passed as a hidden input field
          $_SESSION['cart'][$_POST['product_id']] = array(
            'product' => $product->toArray(),
            'quantity' => 0
          );
        }
        // at this point, the movie is in the session array
        // just increase the quantity with one
        $_SESSION['cart'][$_POST['product_id']]['quantity']++;
      }

      public function cart() {
        // check if we've got an update cart
        if (!empty($_POST['action'])) {
          if ($_POST['action'] == 'empty') {
            // easy: just assign an empty array to the cart
            $_SESSION['cart'] = array();
            // redirect to the same page to avoid resubmission notices on refresh
            header('Location: index.php?page=cart');
            exit();
          }
          if ($_POST['action'] == 'update') {
            // updating cart content: see separate method
            $this->_handleUpdate();
            // redirect to the same page to avoid resubmission notices on refresh
            header('Location: index.php?page=cart');
            exit();
          }
          if ($_POST['action'] == 'order') {
            // updating cart content: see separate method
            $this->_handleUpdate();
            $orderData = $_POST;
            $errors = Order::validate($orderData);
            $isOrderValid = empty($errors);
            if ($isOrderValid) {
              $order = new Order(); 
              $order->email = $orderData['email'];
              $order->save();
              // save the order items
              $orderItems = [];
              foreach($_SESSION['cart'] as $item) {
                $orderItem = new OrderItem();
                $orderItem->product_id = $item['product']['id'];
                $orderItem->amount = $item['quantity'];
                $orderItems[] = $orderItem;
              }
              $order->orderItems()->saveMany($orderItems);
              $_SESSION['info'] = 'Thank you for your order!';
              // clear the cart
              $_SESSION['cart'] = array();
              // redirect to the confirmation page
              // store the order id in the session to avoid people viewing other orders with the querystring
              $_SESSION['order_id'] = $order->id;
              header('Location: index.php?page=cartConfirmation');
              exit();
            } else {
              $_SESSION['error'] = 'Your order could not be placed, please fill in all of the required info.';
              $this->set('errors', $errors);
            }
          }
          
        }
        
        if (!empty($_POST['remove'])) {
          // delete one specific item - see separate method
          $this->_handleRemove();
          // redirect to the same page to avoid resubmission notices on refresh
          header('Location: index.php?page=cart');
          exit();
        }
        $this->set('title', 'Cart');
        $this->set('currentPage', 'cart');
      }
      private function _handleRemove() {
        // the value of $_POST['remove'] is a movie id
        // remove this movie from the session if it exists
        if (isset($_SESSION['cart'][$_POST['remove']])) {
          unset($_SESSION['cart'][$_POST['remove']]);
        }
      }
      private function _handleUpdate() {
        if (empty($_POST['quantity'])) {
          return;
        }
        // the amounts per movie are sent as an associative array
        // look at the html code through "view source" to see the names of the input fields
        // we loop through the quantities and adjust the session cart
        foreach ($_POST['quantity'] as $productId => $quantity) {
          if (!empty($_SESSION['cart'][$productId])) {
            // assign a new quantity
            $_SESSION['cart'][$productId]['quantity'] = $quantity;
          }
        }
        // some movies may have an amount of 0 (zero)
        // remove those from the cart in the method below
        $this->_removeWhereQuantityIsZero();
      }

      private function _removeWhereQuantityIsZero() {
        // loop through the entire cart
        foreach($_SESSION['cart'] as $movieId => $info) {
          // when the amount is equal or smaller than zero, remove it from the cart
          if ($info['quantity'] <= 0) {
            unset($_SESSION['cart'][$movieId]);
          }
        }
      }

      public function cartConfirmation() {
        $order = false;
        if (!empty($_SESSION['order_id'])) {
          $order = Order::find($_SESSION['order_id']);
        }
        if (empty($order)) {
          $_SESSION['error'] = 'Invalid Order';
          header('Location: index.php');
          exit();
        }
        $this->set('order', $order);
        $this->set('title', 'Order Confirmation');
        $this->set('currentPage', 'cart');
      }
}
?>